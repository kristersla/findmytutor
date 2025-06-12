@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8fbff;
    }

    .hero {
        text-align: center;
        margin: 40px 20px 20px;
    }

    .hero h2 {
        color: #1d4ed8;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: bold;
    }

    .hero p {
        font-size: 28px;
        font-weight: bold;
        margin-top: 10px;
        color: #111827;
    }

    .search-bar {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .search-wrapper {
        position: relative;
        width: 100%;
        max-width: 400px;
    }

    .search-wrapper input {
        width: 100%;
        padding: 10px 40px 10px 20px;
        border-radius: 20px;
        border: 1px solid #ccc;
        font-size: 16px;
        background-color: white;
        outline: none;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .autocomplete-results {
        position: absolute;
        top: 125%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-height: 250px;
        overflow-y: auto;
        z-index: 10;
    }

    .autocomplete-entry {
      padding: 12px 20px;
      display: flex;
      flex-direction: column;
      cursor: pointer;
      border-bottom: 1px solid #eee;
      align-items: flex-start;
    }

    .autocomplete-entry:last-child {
        display: flex;
        border-bottom: none;
        flex-direction: column;
        align-content: stretch;
        justify-content: space-evenly;
        align-items: flex-start;
    }

    .autocomplete-entry:hover {
        background-color: #f9f9f9;
    }

    .autocomplete-name {
        font-weight: bold;
        margin-bottom: 2px;
    }

    .autocomplete-bio {
        font-size: 14px;
        color: #666;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .card {
      display: flex;
      position: relative;
      justify-content: center;
      border-radius: 20px;
      overflow: hidden;
      height: 180px;
      align-items: center;
      text-decoration: none;
      color: inherit;
          
    }
    .card::before {
        content: '';
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.3); /* adjust darkness here */
        z-index: 1;
    }
    .card:hover {
        transform: translateY(-2px);
    }

    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      filter: blur(2px);
      transform: scale(1.1);
      position: absolute;
      top: 0;
      left: 0;
      z-index: 0;
    }

    .card h3 {
      position: relative;
      z-index: 1;
      margin: 0;
      padding: 10px;
      color: white;
      font-size: 25px;
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      text-align: center;
      text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
    }
</style>

<div class="hero">
    <h2>TUTORS</h2>
    <p>Private Tutors for Every Subject</p>

    <div class="search-bar">
        <div class="search-wrapper">
            <input type="text" id="tutor-search" placeholder="Search for a tutor..." autocomplete="off">
            <span class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#1d4ed8" viewBox="0 0 24 24">
                    <path d="M21.53 20.47l-5.157-5.157A7.942 7.942 0 0 0 18 10a8 8 0 1 0-8 8 7.942 7.942 0 0 0 5.313-1.627l5.157 5.157a.75.75 0 1 0 1.06-1.06zM4 10a6 6 0 1 1 6 6 6.006 6.006 0 0 1-6-6z"/>
                </svg>
            </span>
            <div id="autocomplete-list" class="autocomplete-results"></div>
        </div>
    </div>
</div>

<div class="grid">
    @foreach ($subjects as $subject)
        @php
            $imageFile = match(strtolower($subject->name)) {
                'writing' => 'history.jpg',
                'literature' => 'english.jpg',
                'history' => 'history.jpg',
                'biology' => 'biology.jpg',
                'chemistry' => 'chemistry.jpg',
                'math' => 'math.jpg',
                'geography' => 'geography.jpg',
                'physics' => 'physics.jpg',
                'culinary' => 'culinary.jpg',
                default => 'default.jpg',
            };
        @endphp
        <a href="{{ route('tutors.bySubject', ['subject' => strtolower($subject->name)]) }}" class="card">
            <img src="{{ asset('images/subjects/' . $imageFile) }}" alt="{{ $subject->name }}">
            <h3>{{ $subject->name }}</h3>
        </a>
    @endforeach
</div>

<script>
    const searchInput = document.getElementById('tutor-search');
    const resultsBox = document.getElementById('autocomplete-list');

    searchInput.addEventListener('input', async function () {
        const query = this.value.trim();
        resultsBox.innerHTML = '';

        if (query.length < 2) return;

        try {
            const response = await fetch(`/tutor-suggestions?name=${encodeURIComponent(query)}`);
            const tutors = await response.json();

            if (tutors.length === 0) {
                resultsBox.innerHTML = '<div class="autocomplete-entry">No tutors found</div>';
                return;
            }

            tutors.forEach(tutor => {
                const entry = document.createElement('div');
                entry.className = 'autocomplete-entry';
                entry.innerHTML = `
                    <div><strong>${tutor.name}</strong></div>
                    <div style="font-size: 0.9em; color: #555;">${tutor.bio}</div>
                `;
                entry.addEventListener('click', () => {
                    window.location.href = `/tutors/${tutor.id}`;
                });
                resultsBox.appendChild(entry);
            });
        } catch (err) {
            console.error('Error fetching tutors:', err);
        }
    });
</script>

@endsection
