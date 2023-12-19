<form method="post" action="{{ route('afficherEleves') }}">
    @csrf
    <button type="submit">Afficher la liste des élèves</button>
</form>