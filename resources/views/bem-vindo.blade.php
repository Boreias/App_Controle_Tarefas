Site da aplicação

@auth

    <h1>Usuário autenticado</h1>
    <p>ID {{ Auth::user()->id }}/p>
    <p>Nome {{ Auth::user()->name }}/p>
    <p>Email {{ Auth::user()->email }}/p>

@endauth

@guest

    <h1>Usuário visitante</h1>

@endguest