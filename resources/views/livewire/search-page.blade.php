<div class="card">
    <div class="card-header">
        <select class="form-control w-50 mr-2"
                wire:model="selectedKey"
            {{count($selectedSubstances) > 4 ? 'disabled' : ''}}>
            <option value="">Select Substances</option>
            @foreach($substances as $key => $item)
                <option value="{{$key}}">{{$item['id'].'-'.$item['name']}}</option>
            @endforeach
        </select>
        <div>
            @foreach($selectedSubstances as $key => $item)
                <a href="" class="badge badge-primary" wire:click.prevent="delete({{$key}})">
                    {{$item['name']}}
                </a>
            @endforeach
        </div>
    </div>
    <div class="card-body">
        @if (count($drugs))
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Substances count</th>
                    <th scope="col">Matches count</th>
                    <th scope="col">Matches Substances</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drugs as $drug)
                    <tr>
                        <th scope="row">{{$drug->id}}</th>
                        <td>{{$drug->name}}</td>
                        <td>{{$drug->substances_count}}</td>
                        <td>{{$drug->matches_count}}</td>
                        <td>
                            @foreach($drug->substances as $substance)
                                <span class="badge badge-primary">
                                    {{$substance->name}}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">
                {{count($selectedSubstances) == 0 ? 'Select Substances' : 'Choose more'}}
            </div>
        @endif
    </div>
    <div class="card-footer">
        @if(count($drugs))
            {{$drugs->links()}}
        @endif
    </div>
</div>
