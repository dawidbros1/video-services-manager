<div class="w-1/3 p-2 group"
    data-id="{{$details->id}}"
    data-name="{{$details->name}}"
    data-thumb="{{$details->thumb}}"
    >
    <div class="flex p-2" style="border: 1px solid black">
        <img class="pr-2 h-8" src="{{ $details->thumb }}" />
        <p class="mt-1" style="width: 75%">{{ $details->name }}</p>

        <div class="mr-2 flex mt-1 p-1" style="border: 1px solid black;">
            <img 
                id = "update_group_{{$details->id}}" 
                class="icon mr-1 pr-1 update_group" 
                style="border-right: 1px solid black;" 
                src="{{ asset('images/edit.png') }}" 
                title="Edytuj"
            >

            <form action="{{ route('groups.delete') }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć tę grupę?')">
                @csrf 
                @method('DELETE')
                
                <input type="hidden" name="id" value="{{ $details->id }}">

                <img class="icon delete_group" src="{{ asset('images/delete.png') }}" title="Usuń">

                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" style="display: none">Usuń grupę</button>
            </form>
        </div>
    </div>
</div>