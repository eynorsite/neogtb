<!DOCTYPE html>
<html><body>
<h2>{{ $requests->count() }} demande(s) RGPD en retard</h2>
<p>Les demandes suivantes approchent ou dépassent le délai légal de 30 jours :</p>
<ul>
@foreach($requests as $req)
<li>Demande #{{ $req->id }} - {{ $req->type }} - reçue le {{ $req->created_at->format('d/m/Y') }} ({{ $req->created_at->diffInDays(now()) }} jours)</li>
@endforeach
</ul>
<p>Connectez-vous au back-office pour les traiter : {{ url('/admin/gdpr-requests') }}</p>
</body></html>
