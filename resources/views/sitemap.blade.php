<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Student Management Home --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Student Detail Pages --}}
    @foreach($students as $student)

        <url>
            <loc>{{ url('/students/' . $student->slug) }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>

    @endforeach

</urlset>