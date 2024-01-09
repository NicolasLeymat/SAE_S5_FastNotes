@php 
  use App\Models\Admin;
  use App\Models\Professeur;
  use App\Models\Eleve;

@endphp
@extends('layouts.fn')

@section('title', 'Accueil Fast Notes')

@section('content')
        <div class="home_container container grid">
          <div class="home_content-fix">
            @auth
              <h2 class="section_title">Bienvenue sur Fast Notes  </br>M/Mme. {{ Auth::user()->nom }} {{ Auth::user()->prenom }} </h2>
              @if(Admin::find(Auth::user()->code) != null)
              <a class="Entreprise button button-index" href="{{ route('dashadmin') }}"> Accéder à la dashboard Admin </a>
              @endif
              @if (Professeur::find(Auth::user()->code) != null)
              <a class="Entreprise button button-index" href="{{ route('evaluations') }}"> Accéder à la dashboard professeur </a>
              @endif
              @if (Eleve::find(Auth::user()->code) != null)
                <a class="Entreprise button button-index" href="/visualisation/{{Auth::user()->code}}"> Accéder à la visualitation des notes </a>
              @endif
            @else
            <form method="POST" action="{{ route('login') }}" class="form">
              @csrf
                <!-- Email Address -->
                <div class="flex_items email_flex">
                    <x-input-label for="code" class="label" :value="__('Identifiant')" />
                    <x-text-input id="code" class="form_input" type="text" name="code" :value="old('code')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="flex_items">
                    <x-input-label for="password" class="label" :value="__('Mot de passe')" />

                    <x-text-input id="password" class="form_input"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                

                <div class="flex_items button-div">


                    <x-primary-button class="button button--flex log_btn">
                        {{ __('Se connecter') }}
                    </x-primary-button>
                </div>
            </form>
            @endauth
          </div>
        </div>
    @endsection