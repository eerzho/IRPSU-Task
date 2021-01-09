<div>
    @if ($displayModal)
        <div class="modal fade show " tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Drug</h5>
                        <button type="button" class="close" wire:click.prevent="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if($step == 1)
                        <div class="modal-body">
                            @foreach($substances as $key => $item)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input wire:model="values.{{ $item->id }}"
                                               type="checkbox"
                                               class="form-checkbox">
                                        <span class="ml-2">Index {{ $item->id}} - {{ $item->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                            <div class="d-flex">

                                <button type="button"
                                        class="btn btn-secondary mr-2"
                                        wire:click.prevent="pageChange('back')">
                                    Back
                                </button>

                                <button type="button" class="btn btn-secondary"
                                        wire:click.prevent="pageChange('next')">
                                    Next
                                </button>

                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-secondary"
                                    wire:click.prevent="close">
                                Close
                            </button>

                            <button type="button"
                                    class="btn btn-primary"
                                    wire:click.prevent="stepChange('next')">
                                Next
                            </button>
                        </div>
                    @elseif($step == 2)
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
                                    wire:click.prevent="stepChange('back')">
                                Back
                            </button>

                            <button type="button"
                                    class="btn btn-primary"
                                    wire:click.prevent="store">
                                Add
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
