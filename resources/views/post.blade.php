<x-layout>
    <article>
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->date }}</p>
        <div>{!! $post->body !!}</div>
    </article>
    <a href="/">Go Back</a>
</x-layout>
