#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Conversion fidèle Markdown -> HTML autonome pour la suite GTB NeoGTB.
Conversion de FORME uniquement : titres h1-h4, tables bordées, listes,
blockquotes (imbriqués), gras/italique, code inline, hr, liens.
AUCUNE modification du contenu (texte, chiffres, normes, articles).
"""

import re
import html
import os

ROOT = "/Users/calmoulrich/ProjetsWeb/neogtb/docs"
CCTP = os.path.join(ROOT, "cctp")


# ---------------------------------------------------------------------------
# Inline rendering : code, gras, italique, liens. Échappe le HTML d'abord.
# ---------------------------------------------------------------------------
def render_inline(text):
    # Protéger les spans de code `...` avant tout échappement / formatage.
    code_spans = []

    def stash_code(m):
        code_spans.append(m.group(1))
        return "\x00CODE%d\x00" % (len(code_spans) - 1)

    text = re.sub(r"`([^`]*)`", stash_code, text)

    # Échapper le HTML du reste.
    text = html.escape(text, quote=False)

    # Liens [texte](url)
    def link(m):
        label = m.group(1)
        url = m.group(2)
        return '<a href="%s">%s</a>' % (html.escape(url, quote=True), label)

    text = re.sub(r"\[([^\]]+)\]\((https?://[^)\s]+)\)", link, text)

    # Gras **...**  (non-greedy, autorise tout sauf délimiteur)
    text = re.sub(r"\*\*([^*]+(?:\*[^*]+)*?)\*\*", r"<strong>\1</strong>", text)
    # Italique *...*  (un seul astérisque)
    text = re.sub(r"(?<![\*\w])\*([^*\n]+?)\*(?!\*)", r"<em>\1</em>", text)

    # Restaurer les spans de code (échappés à l'intérieur de <code>).
    def restore(m):
        idx = int(m.group(1))
        return "<code>%s</code>" % html.escape(code_spans[idx], quote=False)

    text = re.sub(r"\x00CODE(\d+)\x00", restore, text)
    return text


# ---------------------------------------------------------------------------
# Table : détecte un bloc de lignes commençant par | et la ligne séparatrice.
# ---------------------------------------------------------------------------
def split_row(line):
    s = line.strip()
    if s.startswith("|"):
        s = s[1:]
    if s.endswith("|"):
        s = s[:-1]
    # split sur | non échappé
    cells = re.split(r"(?<!\\)\|", s)
    return [c.strip().replace("\\|", "|") for c in cells]


def is_sep_row(line):
    s = line.strip()
    if not s.startswith("|"):
        return False
    return bool(re.match(r"^\|?[\s:|-]+\|?$", s)) and "-" in s


def render_table(rows):
    # rows : liste de lignes brutes (la 2e est la séparatrice)
    header = split_row(rows[0])
    body = [split_row(r) for r in rows[2:]]
    out = ["<table>", "<thead>", "<tr>"]
    for c in header:
        out.append("<th>%s</th>" % render_inline(c))
    out.append("</tr>")
    out.append("</thead>")
    out.append("<tbody>")
    for r in body:
        out.append("<tr>")
        # normaliser le nombre de cellules sur l'en-tête
        for i in range(len(header)):
            cell = r[i] if i < len(r) else ""
            out.append("<td>%s</td>" % render_inline(cell))
        out.append("</tr>")
    out.append("</tbody>")
    out.append("</table>")
    return "\n".join(out)


# ---------------------------------------------------------------------------
# Convertit une liste de lignes Markdown (déjà dé-préfixées de blockquote)
# en HTML. Récursif pour les blockquotes imbriqués.
# ---------------------------------------------------------------------------
def convert_block(lines, hard_breaks=False):
    out = []
    i = 0
    n = len(lines)

    while i < n:
        line = lines[i]
        stripped = line.strip()

        # Ligne vide
        if stripped == "":
            i += 1
            continue

        # Séparateur horizontal --- (à l'intérieur d'une pièce -> simple hr)
        if re.match(r"^(-{3,}|\*{3,}|_{3,})$", stripped):
            out.append("<hr>")
            i += 1
            continue

        # Titres ATX
        m = re.match(r"^(#{1,6})\s+(.*)$", line)
        if m:
            level = len(m.group(1))
            content = m.group(2).strip()
            out.append("<h%d>%s</h%d>" % (level, render_inline(content), level))
            i += 1
            continue

        # Blockquote (peut être imbriqué)
        if stripped.startswith(">"):
            quote_lines = []
            while i < n and (lines[i].strip().startswith(">") or
                             (lines[i].strip() == "" and
                              i + 1 < n and lines[i + 1].strip().startswith(">"))):
                ql = lines[i]
                if ql.strip() == "":
                    quote_lines.append("")
                else:
                    # retirer un seul niveau de '>' + un espace optionnel
                    ql = re.sub(r"^(\s*)>\s?", "", ql)
                    quote_lines.append(ql)
                i += 1
            # Dans un blockquote, on préserve les retours à la ligne visuels
            # (verbatim légal R.175-3 : 1°/2°/3°/4° sur des lignes distinctes).
            inner = convert_block(quote_lines, hard_breaks=True)
            out.append("<blockquote>\n%s\n</blockquote>" % inner)
            continue

        # Table
        if stripped.startswith("|") and i + 1 < n and is_sep_row(lines[i + 1]):
            tbl = [lines[i], lines[i + 1]]
            i += 2
            while i < n and lines[i].strip().startswith("|"):
                tbl.append(lines[i])
                i += 1
            out.append(render_table(tbl))
            continue

        # Bloc de code ``` ... ```
        if stripped.startswith("```"):
            fence = stripped[:3]
            code_buf = []
            i += 1
            while i < n and not lines[i].strip().startswith("```"):
                code_buf.append(lines[i])
                i += 1
            i += 1  # consommer la fence fermante
            code_html = html.escape("\n".join(code_buf), quote=False)
            out.append("<pre><code>%s</code></pre>" % code_html)
            continue

        # Liste non ordonnée
        m_ul = re.match(r"^(\s*)([-*+])\s+(.*)$", line)
        # Liste ordonnée
        m_ol = re.match(r"^(\s*)(\d+)[.)]\s+(.*)$", line)
        if m_ul or m_ol:
            list_html, consumed = parse_list(lines, i, hard_breaks=hard_breaks)
            out.append(list_html)
            i = consumed
            continue

        # Paragraphe : agréger jusqu'à ligne vide / nouveau bloc
        para = [line]
        i += 1
        while i < n:
            nxt = lines[i]
            ns = nxt.strip()
            if (ns == "" or ns.startswith(">") or ns.startswith("#")
                    or ns.startswith("|") or ns.startswith("```")
                    or re.match(r"^(-{3,}|\*{3,}|_{3,})$", ns)
                    or re.match(r"^(\s*)([-*+])\s+", nxt)
                    or re.match(r"^(\s*)(\d+)[.)]\s+", nxt)):
                break
            para.append(nxt)
            i += 1
        if hard_breaks and len(para) > 1:
            # Préserver les retours à la ligne d'un verbatim (blockquote).
            text = "<br>\n".join(render_inline(p.strip()) for p in para)
            out.append("<p>%s</p>" % text)
        else:
            text = " ".join(p.strip() for p in para)
            out.append("<p>%s</p>" % render_inline(text))

    return "\n".join(out)


def list_item_indent(line):
    m = re.match(r"^(\s*)(?:[-*+]|\d+[.)])\s+", line)
    return len(m.group(1)) if m else 0


def parse_list(lines, start, hard_breaks=False):
    """Parse une liste (potentiellement imbriquée) à partir de lines[start]."""
    n = len(lines)
    base_indent = list_item_indent(lines[start])
    ordered = bool(re.match(r"^\s*\d+[.)]\s+", lines[start]))
    start_num = None
    if ordered:
        start_num = re.match(r"^\s*(\d+)[.)]\s+", lines[start]).group(1)

    items = []  # chaque item : (contenu_inline, sous_blocs_lignes)
    i = start
    while i < n:
        line = lines[i]
        if line.strip() == "":
            # une ligne vide peut séparer des items : regarder la suite
            j = i + 1
            if j < n and re.match(r"^(\s*)(?:[-*+]|\d+[.)])\s+", lines[j]) \
                    and list_item_indent(lines[j]) == base_indent:
                i = j
                continue
            else:
                break
        m = re.match(r"^(\s*)(?:[-*+]|\d+[.)])\s+(.*)$", line)
        if not m:
            break
        indent = len(m.group(1))
        if indent < base_indent:
            break
        if indent > base_indent:
            # ne devrait pas arriver ici (géré comme continuation)
            break
        content = m.group(2)
        sub_lines = []
        i += 1
        # collecter continuations / sous-listes (indent > base)
        while i < n:
            nxt = lines[i]
            if nxt.strip() == "":
                # potentielle continuation après ligne vide
                if i + 1 < n and list_item_indent(lines[i + 1]) > base_indent:
                    sub_lines.append("")
                    i += 1
                    continue
                else:
                    break
            ni = list_item_indent(nxt) if re.match(r"^(\s*)(?:[-*+]|\d+[.)])\s+", nxt) else None
            if ni is not None and ni == base_indent:
                break
            if ni is not None and ni > base_indent:
                sub_lines.append(nxt[base_indent + 2:] if len(nxt) > base_indent + 2 else nxt.strip())
                i += 1
                continue
            # ligne de continuation simple (indentée, non-liste)
            if nxt.startswith(" " * (base_indent + 1)):
                sub_lines.append(nxt.strip())
                i += 1
                continue
            break
        items.append((content, sub_lines))

    # rendu
    tag = "ol" if ordered else "ul"
    attr = ' start="%s"' % start_num if (ordered and start_num and start_num != "1") else ""
    if ordered and start_num and start_num == "1":
        attr = ' start="1"'
    parts = ["<%s%s>" % (tag, attr)]
    for content, sub in items:
        inner = render_inline(content)
        if sub and any(s.strip() for s in sub):
            sub_html = convert_block(sub, hard_breaks=hard_breaks)
            parts.append("<li>%s\n%s</li>" % (inner, sub_html))
        else:
            parts.append("<li>%s</li>" % inner)
    parts.append("</%s>" % tag)
    return "\n".join(parts), i


def md_to_html(md_text):
    # normaliser les fins de ligne
    md_text = md_text.replace("\r\n", "\n").replace("\r", "\n")
    lines = md_text.split("\n")
    return convert_block(lines)


# ---------------------------------------------------------------------------
# Gabarit HTML
# ---------------------------------------------------------------------------
CSS = """@page { size: A4; margin: 2cm; }
html { -webkit-text-size-adjust: 100%; }
body {
  font-family: Calibri, Arial, 'Segoe UI', sans-serif;
  font-size: 11pt;
  line-height: 1.45;
  color: #1a1a1a;
  margin: 0;
  padding: 1.5cm 2cm;
  background: #fff;
}
.page { max-width: 19cm; margin: 0 auto; }
h1, h2, h3, h4, h5, h6 {
  font-family: 'Cambria', 'Georgia', 'Times New Roman', serif;
  color: #14304a;
  line-height: 1.2;
  page-break-after: avoid;
}
h1 { font-size: 18pt; border-bottom: 2px solid #14304a; padding-bottom: 4px; margin-top: 0.6em; }
h2 { font-size: 14pt; border-bottom: 1px solid #b8c4d0; padding-bottom: 3px; margin-top: 1.4em; }
h3 { font-size: 12pt; margin-top: 1.1em; color: #1d4d73; }
h4 { font-size: 11pt; margin-top: 0.9em; color: #1d4d73; }
h5, h6 { font-size: 10.5pt; margin-top: 0.8em; color: #1d4d73; }
p { margin: 0.5em 0; text-align: justify; }
ul, ol { margin: 0.4em 0 0.6em 0; padding-left: 1.6em; }
li { margin: 0.18em 0; }
hr { border: 0; border-top: 1px solid #ccc; margin: 1.2em 0; }
code {
  font-family: Consolas, 'Courier New', monospace;
  background: #eef1f4;
  border: 1px solid #d8dde2;
  border-radius: 3px;
  padding: 0 3px;
  font-size: 0.92em;
}
pre { background: #eef1f4; border: 1px solid #d8dde2; border-radius: 3px; padding: 0.6em 0.8em; overflow-x: auto; page-break-inside: avoid; }
pre code { background: none; border: 0; padding: 0; font-size: 0.88em; white-space: pre; }
a { color: #14304a; text-decoration: none; }
table {
  border-collapse: collapse;
  width: 100%;
  margin: 0.8em 0;
  font-size: 10pt;
  page-break-inside: auto;
  border: 1px solid #999;
}
th, td {
  border: 1px solid #999;
  padding: 4px 6px;
  text-align: left;
  vertical-align: top;
}
th { background: #e8ecf0; font-weight: bold; color: #14304a; }
thead { display: table-header-group; }
tr { page-break-inside: avoid; }
tbody tr:nth-child(even) { background: #f7f9fb; }
blockquote {
  background: #f4f6f8;
  border-left: 4px solid #2a6ca8;
  margin: 0.9em 0;
  padding: 0.5em 0.9em;
  page-break-inside: avoid;
}
blockquote blockquote { border-left-color: #7a99b5; background: #eef2f6; margin: 0.6em 0; }
blockquote p:first-child { margin-top: 0; }
blockquote p:last-child { margin-bottom: 0; }
blockquote table { background: #fff; }
strong { font-weight: 700; }
em { font-style: italic; }

/* Cover page */
.cover {
  page-break-after: always;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  min-height: 24cm;
  padding: 2cm 1cm;
}
.cover .brand {
  font-family: 'Cambria', 'Georgia', serif;
  font-size: 26pt;
  font-weight: bold;
  letter-spacing: 2px;
  color: #14304a;
  margin-bottom: 2.5cm;
}
.cover .doc-title {
  font-family: 'Cambria', 'Georgia', serif;
  font-size: 22pt;
  font-weight: bold;
  color: #14304a;
  line-height: 1.3;
  max-width: 16cm;
  margin: 0 auto;
  border: 0;
  padding: 0;
}
.cover .doc-subtitle {
  font-size: 14pt;
  color: #2a6ca8;
  margin-top: 1cm;
  font-style: italic;
}
.cover .rule {
  width: 8cm;
  border-top: 2px solid #2a6ca8;
  margin: 1.5cm auto;
}
.cover .date-block {
  margin-top: 3cm;
  font-size: 12pt;
  color: #333;
}

/* Sommaire cliquable */
.toc {
  page-break-after: always;
  max-width: 19cm;
  margin: 0 auto;
  padding: 1cm 0;
}
.toc h2 { margin-top: 0; }
.toc ol { padding-left: 1.4em; }
.toc li { margin: 0.35em 0; font-size: 11.5pt; }
.toc a { color: #1d4d73; }
.toc a:hover { text-decoration: underline; }
.toc .toc-piece { font-weight: 600; color: #14304a; }

/* Séparateur de pièce */
.doc-section { page-break-before: always; }
.piece-sep {
  page-break-before: always;
  text-align: center;
  padding: 6cm 1cm 0 1cm;
}
.piece-sep .piece-ref {
  font-family: 'Cambria', 'Georgia', serif;
  font-size: 16pt;
  color: #2a6ca8;
  letter-spacing: 1px;
  margin-bottom: 0.6cm;
}
.piece-sep .piece-name {
  font-family: 'Cambria', 'Georgia', serif;
  font-size: 22pt;
  font-weight: bold;
  color: #14304a;
  line-height: 1.3;
  max-width: 16cm;
  margin: 0 auto;
}
.piece-sep .rule { width: 7cm; border-top: 2px solid #2a6ca8; margin: 1.2cm auto; }

@media print {
  body { padding: 0; font-size: 10.5pt; }
  .page { max-width: none; }
  a { color: #14304a; }
  print-color-adjust: exact;
  -webkit-print-color-adjust: exact;
  blockquote { background: #f4f6f8 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  blockquote blockquote { background: #eef2f6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  th { background: #e8ecf0 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  tbody tr:nth-child(even) { background: #f7f9fb !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  h1, h2, h3, h4 { color: #14304a !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}"""


def page_html(title, cover_html, toc_html, sections_html):
    return """<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>%s</title>
<style>
%s
</style>
</head>
<body>
%s
%s
%s
</body>
</html>
""" % (html.escape(title, quote=False), CSS, cover_html, toc_html, sections_html)


def cover_block(brand_title, subtitle, mention="NeoGTB"):
    parts = ['<div class="cover">']
    parts.append('<div class="brand">%s</div>' % html.escape(mention, quote=False))
    parts.append('<div class="doc-title">%s</div>' % brand_title)
    parts.append('<div class="rule"></div>')
    if subtitle:
        parts.append('<div class="doc-subtitle">%s</div>' % html.escape(subtitle, quote=False))
    parts.append('<div class="date-block">Date : ______________________</div>')
    parts.append('</div>')
    return "\n".join(parts)


def toc_block(entries):
    # entries : liste de (anchor, label)
    parts = ['<div class="toc">', '<h2>Sommaire du dossier</h2>', '<ol>']
    for anchor, label in entries:
        parts.append('<li><a href="#%s"><span class="toc-piece">%s</span></a></li>'
                     % (anchor, html.escape(label, quote=False)))
    parts.append('</ol>')
    parts.append('</div>')
    return "\n".join(parts)


def piece_separator(ref, name, anchor):
    return ('<div class="piece-sep" id="%s">\n'
            '<div class="piece-ref">%s</div>\n'
            '<div class="piece-name">%s</div>\n'
            '<div class="rule"></div>\n'
            '</div>' % (anchor, html.escape(ref, quote=False), html.escape(name, quote=False)))


def read_md(path):
    with open(path, "r", encoding="utf-8") as f:
        return f.read()


def build_dossier(out_path, title, cover_title, cover_subtitle, pieces):
    """
    pieces : liste de dicts {ref, name, anchor, file, sep(bool)}
    """
    toc_entries = [(p["anchor"], "%s — %s" % (p["ref"], p["name"]) if p["ref"] else p["name"])
                   for p in pieces]
    toc = toc_block(toc_entries)
    cover = cover_block(cover_title, cover_subtitle)

    sections = []
    for p in pieces:
        sep = piece_separator(p["ref"], p["name"], p["anchor"])
        md = read_md(p["file"])
        body = md_to_html(md)
        sections.append(sep)
        sections.append('<div class="page">\n%s\n</div>' % body)

    out = page_html(title, cover, toc, "\n".join(sections))
    with open(out_path, "w", encoding="utf-8") as f:
        f.write(out)
    return len(out.encode("utf-8"))


def build_simple(out_path, title, cover_title, cover_subtitle, pieces):
    """Variante freebie : page de garde + pièces avec saut de page, sans sommaire séparé."""
    cover = cover_block(cover_title, cover_subtitle)
    sections = []
    for idx, p in enumerate(pieces):
        md = read_md(p["file"])
        body = md_to_html(md)
        cls = "page doc-section" if idx > 0 else "page"
        # première pièce après la cover : la cover gère déjà le saut ; on force
        # un saut avant chaque pièce pour respecter "saut de page entre les deux".
        if idx == 0:
            sections.append('<div class="page">\n%s\n</div>' % body)
        else:
            sections.append('<div class="page doc-section">\n%s\n</div>' % body)
    out = page_html(title, cover, "", "\n".join(sections))
    with open(out_path, "w", encoding="utf-8") as f:
        f.write(out)
    return len(out.encode("utf-8"))


# ---------------------------------------------------------------------------
# Définition des trois dossiers
# ---------------------------------------------------------------------------
def main():
    # === 1. Dossier consultation ===
    consult_pieces = [
        {"ref": "A1", "name": "CCTP GTB multi-protocole vendor-neutral", "anchor": "piece-a1",
         "file": os.path.join(CCTP, "CCTP-GTB-multiprotocole-vendor-neutral.md")},
        {"ref": "A2", "name": "CCAP — clauses GTB", "anchor": "piece-a2",
         "file": os.path.join(CCTP, "A2_CCAP-clauses-GTB.md")},
        {"ref": "A3", "name": "Cadre de liste de points", "anchor": "piece-a3",
         "file": os.path.join(CCTP, "A3_cadre-liste-de-points.md")},
        {"ref": "A4", "name": "Cadre BPU / DPGF + TCO", "anchor": "piece-a4",
         "file": os.path.join(CCTP, "A4_cadre-BPU-DPGF.md")},
        {"ref": "A5", "name": "Cadre du mémoire technique", "anchor": "piece-a5",
         "file": os.path.join(CCTP, "A5_cadre-memoire-technique.md")},
        {"ref": "A6", "name": "Grille de dépouillement GTB", "anchor": "piece-a6",
         "file": os.path.join(CCTP, "grille-depouillement-GTB.md")},
        {"ref": "A7", "name": "Notice d'usage MOA", "anchor": "piece-a7",
         "file": os.path.join(CCTP, "A7_notice-usage-MOA.md")},
        {"ref": "Annexe C0", "name": "Sources et statuts", "anchor": "piece-c0",
         "file": os.path.join(CCTP, "C0_sources-et-statuts.md")},
    ]
    s1 = build_dossier(
        os.path.join(CCTP, "Dossier-Consultation-GTB.html"),
        "Dossier de consultation GTB — Kit vendor-neutral — NeoGTB",
        "Dossier de consultation GTB<br>Kit vendor-neutral",
        "Pièces A1 à A7 + Annexe C0 — NeoGTB",
        consult_pieces,
    )
    print("Dossier-Consultation-GTB.html : %d octets" % s1)

    # === 2. Dossier audit ===
    audit_pieces = [
        {"ref": "B1", "name": "Méthodologie d'audit & de classification", "anchor": "piece-b1",
         "file": os.path.join(CCTP, "B1_methodologie-audit-classification.md")},
        {"ref": "B2", "name": "Exemple d'audit de conformité — décret BACS", "anchor": "piece-b2",
         "file": os.path.join(ROOT, "exemple-audit-conformite-bacs.md")},
        {"ref": "B3", "name": "Grille de fonctions NF EN ISO 52120-1", "anchor": "piece-b3",
         "file": os.path.join(CCTP, "B3_grille-fonctions-52120.md")},
        {"ref": "B4", "name": "Clause de responsabilité & de périmètre", "anchor": "piece-b4",
         "file": os.path.join(CCTP, "B4_clause-responsabilite-perimetre.md")},
        {"ref": "Annexe C0", "name": "Sources et statuts", "anchor": "piece-c0",
         "file": os.path.join(CCTP, "C0_sources-et-statuts.md")},
    ]
    s2 = build_dossier(
        os.path.join(CCTP, "Dossier-Audit-GTB.html"),
        "Dossier audit & classification GTB — décret BACS / NF EN ISO 52120-1 — NeoGTB",
        "Dossier audit &amp; classification GTB<br>décret BACS / NF EN ISO 52120-1",
        "Pièces B1 à B4 + Annexe C0 — NeoGTB",
        audit_pieces,
    )
    print("Dossier-Audit-GTB.html : %d octets" % s2)

    # === 3. Freebie CCTP imprimable (régénération) ===
    free_pieces = [
        {"ref": "A1", "name": "CCTP GTB multi-protocole vendor-neutral", "anchor": "piece-a1",
         "file": os.path.join(CCTP, "CCTP-GTB-multiprotocole-vendor-neutral.md")},
        {"ref": "A6", "name": "Grille de dépouillement GTB", "anchor": "piece-a6",
         "file": os.path.join(CCTP, "grille-depouillement-GTB.md")},
    ]
    s3 = build_simple(
        os.path.join(CCTP, "CCTP-GTB-vendor-neutral.html"),
        "CCTP GTB multi-protocole vendor-neutral — NeoGTB",
        "CCTP GTB multi-protocole vendor-neutral",
        "Modèle imprimable — CCTP (A1) + Grille de dépouillement (A6)",
        free_pieces,
    )
    print("CCTP-GTB-vendor-neutral.html : %d octets" % s3)


if __name__ == "__main__":
    main()
