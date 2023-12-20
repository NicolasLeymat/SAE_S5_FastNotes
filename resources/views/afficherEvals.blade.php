<h2>Liste des évaluations</h2>
<ul>
    @foreach($evaluations as $evaluation)
        <li>{{ $evaluation->libelle }} - Coefficient: {{ $evaluation->coef }}</li>
    @endforeach
</ul>