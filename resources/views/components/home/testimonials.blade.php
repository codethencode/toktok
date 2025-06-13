<section class="bg-gray-50 py-10">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl font-bold text-gray-900 pt-6">Ce que pensent nos clients</h2>
      <p class="mt-4 text-gray-600 text-lg">Avocats, collaborateurs, juristes... tous saluent la qualité de notre accompagnement.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @php
        $testimonials = [
          ['initials' => 'M.L.', 'text' => 'Un service d\'une réactivité rare. Mon dossier a été remis au tribunal le jour même. Je recommande sans hésiter.'],
          ['initials' => 'A.B.', 'text' => 'Fini les déplacements inutiles. Tout est fluide, sécurisé, et parfaitement documenté. Un vrai gain de temps.'],
          ['initials' => 'J.R.', 'text' => 'Le service de rédaction est d\'une qualité irréprochable. J\'ai pu déléguer mes conclusions en toute confiance.'],
          ['initials' => 'S.D.', 'text' => 'Tout est intuitif. Le portail client est clair, le suivi en temps réel est un vrai plus. Excellent support également.'],
          ['initials' => 'N.G.', 'text' => 'Service ultra fiable. Mes dossiers arrivent toujours à temps, et je suis notifié à chaque étape. Bravo !'],
          ['initials' => 'E.C.', 'text' => 'Enfin un partenaire digital qui comprend les contraintes d’un cabinet d’avocats. Professionnalisme et rigueur.'],
        ];
      @endphp

      @foreach ($testimonials as $testimonial)
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition pt-6 pb-10">
          <div class="flex items-center justify-between mb-2 pb-6">
            <div class="text-sm font-medium text-indigo-600">{{ $testimonial['initials'] }}</div>
            <div class="flex items-center space-x-1">
              @for ($i = 0; $i < 5; $i++)
                <span class="h-2 w-2 bg-indigo-500 rounded-full"></span>
              @endfor
              <span class="ml-2 text-xs text-gray-500">5/5</span>
            </div>
          </div>
          <p class="text-gray-700 text-base italic leading-relaxed">“{{ $testimonial['text'] }}”</p>
        </div>
      @endforeach
    </div>
  </div>
</section>







