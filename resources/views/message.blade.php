<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Mensajes</title>
    <script src="https://cdn.tailwindcss.com"></script> </head>
<body class="p-10">

    <h1 class="text-2xl font-bold mb-5">Nuevo Mensaje</h1>

    <form action="{{ route('messages.store') }}" method="POST" class="mb-10">
        @csrf
        <div class="mb-4">
            <label>Event ID:</label>
            <input type="text" name="event_id" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Contenido:</label>
            <textarea name="content" class="border p-2 w-full" required></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
    </form>

    <hr class="mb-10">

    <h2 class="text-xl font-bold mb-5">Mensajes Actuales</h2>

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Event ID</th>
                <th class="border px-4 py-2">Contenido</th>
                <th class="border px-4 py-2">Creado el</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $msg)
            <tr>
                <td class="border px-4 py-2">{{ $msg->id }}</td>
                <td class="border px-4 py-2">{{ $msg->event_id }}</td>
                <td class="border px-4 py-2">{{ $msg->content }}</td>
                <td class="border px-4 py-2">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>