<form method="post" action="{{ route('afficher-eleves') }}">
    @csrf
    <button type="submit">Afficher la liste des élèves</button>
</form>