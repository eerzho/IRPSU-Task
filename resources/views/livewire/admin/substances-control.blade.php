<div class="card">
    <livewire:admin.substance-create-modal></livewire:admin.substance-create-modal>
    <div class="card-header d-flex">
         <input class="form-control w-50"
                type="text"
                placeholder="Search with name"
                wire:model="search">

        <button class="btn btn-primary ml-auto"
                type="button"
                wire:click.prevent="openModal">
            Add Substance
        </button>
    </div>
    <div class="card-body">

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Created at</th>
                <th scope="col">Drugs Count</th>
                <th scope="col">Visible</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $key => $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->created_at->format('d.m.Y')}}</td>
                    <td>{{$item->drugs_count}}</td>
                    <td>
                        <button class="btn btn-{{$item->visible ? 'secondary' : 'success'}}"
                                type="button" onclick="confirm('Are you sure ?') || event.stopImmediatePropagation()"
                                wire:click.prevent="changeVisible({{$item->id}})">
                            {{$item->visible ? 'Hide' : 'Show'}}
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-danger"
                                type="button"
                                onclick="confirm('Delete this item ?') || event.stopImmediatePropagation()"
                                wire:click.prevent="delete({{$item->id}})">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{$items->links()}}
    </div>
</div>
