<div>
    @if ($displayModal)
        <div class="modal fade show " tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Substance</h5>
                        <button type="button" class="close" wire:click.prevent="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control @error('name') is-invalid @enderror"
                               type="text"
                               placeholder="Input name"
                               wire:model="name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                wire:click.prevent="close">
                            Close
                        </button>

                        <button type="button"
                                class="btn btn-primary"
                                wire:click.prevent="store">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
