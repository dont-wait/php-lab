@props(['title'])

<section style="border:1px solid #ddd; border-radius:8px; padding:16px; margin:12px 0;">
    <h3>{{ $title }}</h3>
    <div>{{ $slot }}</div>
</section>
