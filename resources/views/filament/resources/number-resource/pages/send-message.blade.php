<x-filament-panels::page>
    <!-- select the number to send the message -->
    <form wire:submit.prevent="submit">
        <div class="flex flex-col">
            <label for="number" class="font-bold text-2xl">Número</label>
            <select name="number" id="number" class="border border-gray-300 rounded-md text-black">
                <option value="">Seleccione un número</option>
                @foreach (auth()->user()->numbers as $number)
                    <option value="{{ $number->id }}">{{ $number->id ." | ". $number->name }}</option>
                @endforeach
            </select>

            <label for="destination" class="font-bold text-2xl">Destinatario</label>
            <input type="text" name="destination" id="destination" class="border border-gray-300 rounded-md text-black">

            <label for="message" class="font-bold text-2xl">Mensaje</label>
            <textarea name="message" id="message" cols="30" rows="10" class="border border-gray-300 rounded-md text-black"></textarea>

            <button class="bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Enviar
            </button>
        </div>
    </form>
</x-filament-panels::page>
