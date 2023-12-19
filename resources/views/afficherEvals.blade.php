<form method="post" action="{{ route('afficher-evaluations') }}">
    @csrf
    <button type="submit">Afficher la liste des évaluations</button>
</form>