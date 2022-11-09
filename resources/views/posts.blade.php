<x-layout>
    @foreach ($posts as $post)
        <article class="{{ $loop->even ? 'foo' : 'bar' }}">
            <h1>
                <a href="/post/{{ $post->slug }}">
                    {{ $post->title }}
                </a>
            </h1>
            <p>{{ $post->date }}</p>
            <p>{{ $post->excerpt }}</p>
        </article>
    @endforeach
</x-layout>
