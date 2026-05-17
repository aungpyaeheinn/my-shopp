<div>
    <form wire:submit="update">

        <input
            type="text"
            wire:model="title"
        >

        <textarea
            wire:model="description"
        ></textarea>

        <select wire:model="advisor_id">

            @foreach($users as $user)

                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>

            @endforeach

        </select>

        <button type="submit">
            Update
        </button>

    </form>
</div>