<form method="post" action="{{ route('afficherEvals') }}">
    @csrf
    <button type="submit">Afficher la liste des évaluations</button>
</form>