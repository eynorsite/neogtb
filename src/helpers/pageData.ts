import pagesJson from '../data/pages.json';

export interface PageHero {
  title: string;
  subtitle: string;
  description: string;
  cta_text: string | null;
  cta_url: string | null;
  image: string | null;
}

export interface PageSeo {
  meta_title: string;
  meta_description: string;
  meta_keywords: string;
  og_title: string | null;
  og_description: string | null;
  og_image: string | null;
}

export interface PageBrick {
  type: string;
  name: string;
  content: Record<string, any>;
  settings: Record<string, any>;
}

export interface PageData {
  slug: string;
  name: string;
  hero: PageHero;
  seo: PageSeo;
  bricks: PageBrick[];
}

const pages = pagesJson as Record<string, PageData>;

export function getPageData(slug: string): PageData | null {
  return pages[slug] ?? null;
}

export function getHero(slug: string): PageHero | null {
  return pages[slug]?.hero ?? null;
}

export function getSeo(slug: string): PageSeo | null {
  return pages[slug]?.seo ?? null;
}

export function getBricks(slug: string): PageBrick[] {
  return pages[slug]?.bricks ?? [];
}

export function getBricksByType(slug: string, type: string): PageBrick[] {
  return getBricks(slug).filter(b => b.type === type);
}
