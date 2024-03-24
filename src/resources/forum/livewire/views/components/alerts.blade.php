@if (Session::has('alerts'))
    @foreach (Session::get('alerts') as $alert)
        @include ('forum::components.alert', $alert)
    @endforeach
@endif

@if (isset($errors) && !$errors->isEmpty())
    @foreach ($errors->all() as $error)
        @include ('forum::components.alert', ['type' => 'danger', 'message' => $error])
    @endforeach
@endif
