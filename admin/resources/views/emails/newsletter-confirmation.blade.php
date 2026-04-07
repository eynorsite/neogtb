<!DOCTYPE html>
<html><body>
<h2>Confirmez votre inscription</h2>
<p>Bonjour,</p>
<p>Cliquez sur le lien suivant pour confirmer votre inscription à la newsletter NeoGTB :</p>
<p><a href="{{ url('/newsletter/confirm/' . $subscriber->confirmation_token) }}">Confirmer mon inscription</a></p>
<p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>
</body></html>
