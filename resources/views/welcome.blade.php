@extends('layouts.app')


@section('content')
  <h1> Last news : </h1>

  @foreach($articles as $article)
  <div>
    <a href="{{ route('home.article', $article) }}">
      <h3><?php echo $article->title  ?></h3>
    </a>
  </div>
  @endforeach

  {{ $articles->links() }}


@endsection
