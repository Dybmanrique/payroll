<h1>Hola</h1>

<form action="{{ route('empleado.logout')}}" method="POST">
    @csrf
    <input type="submit" value="Logout">
</form>