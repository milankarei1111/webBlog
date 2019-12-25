@if (count($breadcrumbs))
  <ol class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
      @if ($breadcrumb->url && !$loop->last)
        <li><a href="{{ $breadcrumb->url }}"><i class="{{ $breadcrumb->icon ?? '' }}"></i> {{ $breadcrumb->title }}</a></li>
      @else
        <li class="active"><i class="{{ $breadcrumb->icon ?? '' }}"></i> {{ $breadcrumb->title }}</li>
      @endif
    @endforeach
  </ol>
@endif
