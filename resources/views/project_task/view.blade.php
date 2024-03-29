<div class="card bg-none card-box">
<div class="modal-dialog modal-vertical modal-lg side-modal" role="document" id="{{ $task->id }}">
    <div class="modal-content">
        <div class="modal-header">
            <div class="col d-flex align-items-center">
                <div class="custom-control custom-checkbox mt-n1">
                    <input type="checkbox" class="custom-control-input" id="complete_task" @if($task->is_complete == 1) checked @endif data-url="{{ route('change.complete',[$task->project_id,$task->id]) }}">
                    <label class="custom-control-label" for="complete_task"></label>
                </div>
                <h6 class="mb-0">{{ $task->name }}</h6>
            </div>
            <div class="col-auto">
                <div class="actions text-right">
                    <div class="float-left">
                        <a href="#" class="action-item {{($task->is_favourite) ? 'action-favorite' : ''}} active" data-url="{{ route('change.fav',[$task->project_id,$task->id]) }}" id="add_favourite" data-toggle="tooltip" data-original-title="{{__('Mark as favorite')}}">
                            <i class="fas fa-star"></i>
                        </a>
                    </div>
                    <div class="priority-color float-right">
                        <div class="colorPickSelector" style="background-color: {{$task->priority_color}}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scrollbar-inner">
            <div class="modal-body">
                <div class="row mb-4 align-items-center">
                    <div class="col-6">
                        <label class="form-control-label mb-0">
                            {{__('See Detail')}}
                        </label>
                    </div>
                    <div class="col-6 text-right">
                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-toggle="collapse" data-target="#overview">
                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                        </a>
                    </div>
                </div>
                <div id="overview" class="collapse">
                    <b>{{__('Estimated Hours')}}</b> : <span>{{ (!empty($task->estimated_hrs)) ? number_format($task->estimated_hrs) : '-' }}</span> <br>
                    <b>{{__('Milestone')}}</b> : <span>{{ (!empty($task->milestone)) ? $task->milestone->title : '-' }}</span> <br>
                    <b>{{__('Description')}}</b> <br> <span>{{ (!empty($task->description)) ? $task->description : '-' }}</span>
                </div>
                <hr/>
                @if($allow_progress == 'false')
                    <div class="row align-items-center">
                        <div class="col-12 pb-2">
                            <label class="form-control-label mb-0">
                                {{__('Task Progress')}} : <b id="t_percentage">{{ $task->progress }}</b>%
                            </label>
                        </div>
                        <div class="col-12">
                            <div id="progress-result" class="tab-pane tab-example-result fade show active" role="tabpanel" aria-labelledby="progress-result-tab">
                                <input type="range" class="task_progress custom-range" value="{{ $task->progress }}" id="task_progress" name="progress" data-url="{{ route('change.progress',[$task->project_id,$task->id]) }}">
                            </div>
                        </div>
                    </div>
                    <hr/>
                @endif
                <div class="row mb-4 align-items-center">
                    <div class="col-6">
                        <label class="form-control-label mb-0">
                            {{__('Checklist')}}
                        </label>
                    </div>
                    <div class="col-6 text-right">
                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-toggle="collapse" data-target="#form-checklist">
                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                            <span class="btn-inner--text">{{__('Add item')}}</span>
                        </a>
                    </div>
                </div>
                <div class="checklist" id="checklist">
                    <form method="post" id="form-checklist" class="collapse pb-2" data-action="{{route('checklist.store',[$task->project_id,$task->id])}}">
                        <div class="card border shadow-none">
                            <div class="px-3 py-2 row align-items-center">
                              @csrf
                                <div class="col-10">
                                    <input type="text" name="name" required class="form-control" placeholder="{{__('Checklist Name')}}"/>
                                </div>
                                <div class="col-2 card-meta d-inline-flex align-items-center">
                                    <button class="btn btn-sm btn-white float-right add-small" type="submit" id="checklist_submit">
                                        <i class="fas fa-plus "></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @foreach($task->checklist as $checklist)
                        <div class="card border shadow-none checklist-member">
                            <div class="px-3 py-2 row align-items-center">
                                <div class="col-10">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check-item-{{ $checklist->id }}" @if($checklist->status) checked @endif data-url="{{route('checklist.update',[$task->project_id,$checklist->id])}}">
                                        <label class="custom-control-label h6 text-sm" for="check-item-{{ $checklist->id }}">{{ $checklist->name }}</label>
                                    </div>
                                </div>
                                <div class="col-auto card-meta d-inline-flex align-items-center ml-sm-auto">
                                    <a href="#" class="action-item delete-checklist" data-url="{{route('checklist.destroy',[$task->project_id,$checklist->id])}}">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr/>
                <div class="row mb-4 align-items-center">
                    <div class="col-6">
                        <label class="form-control-label mb-0">{{__('Attachments' )}}</label>
                    </div>
                    <div class="col-6 text-right">
                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-toggle="collapse" data-target="#add_file">
                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                            <span class="btn-inner--text">{{__('Add item')}}</span>
                        </a>
                    </div>
                </div>
                <form method="post" id="add_file" class="collapse pb-2">
                <div class="card mb-3 border shadow-none collapse" id="">
                    <div class="card border-0 shadow-none mb-0">
                        <div class="px-3 py-2 row align-items-center">
                            <div class="col-10">
                                <input type="file" name="task_attachment" id="task_attachment" required class="form-control"/>
                                <label for="task_attachment">
                                    <i class="fa fa-upload"></i>
                                    <span class="attachment_text">{{__('Choose a file…')}}</span>
                                </label>
                            </div>
                            <div class="col-2 card-meta d-inline-flex align-items-center">
                                <button class="btn btn-sm btn-white float-right add-small" type="submit"  id="file_attachment_submit" data-action="{{ route('comment.store.file',[$task->project_id,$task->id]) }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <div id="comments-file">
                    @foreach($task->taskFiles as $file)
                        <div class="card mb-3 border shadow-none task-file">
                            <div class="px-3 py-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <img src="{{ asset('assets/img/icons/files/'.$file->extension.'.png') }}" class="img-fluid" style="width: 40px;">
                                    </div>
                                    <div class="col ml-n2">
                                        <h6 class="text-sm mb-0">
                                            <a href="#">{{ $file->name }}</a>
                                        </h6>
                                        <p class="card-text small text-muted">{{ $file->file_size }}</p>
                                    </div>
                                    <div class="col-auto actions">
                                        <a href="{{asset(Storage::url('tasks/'.$file->file))}}" download class="action-item" role="button">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @auth('web')
                                            <a href="#" class="action-item delete-comment-file" role="button" data-url="{{route('comment.destroy.file',[$task->project_id,$task->id,$file->id])}}">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr/>
                <label class="form-control-label mb-4">{{__('Activity')}}</label>
                <div class="list-group list-group-flush mb-0">
                    @foreach($task->activity_log() as $activity)
                    @php $user = \App\Models\User::find($activity->user_id); @endphp

                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="#" class="avatar avatar-sm">
                                        <img data-toggle="tooltip" data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('assets/img/avatar/avatar-1.png')}}" @endif title="{{ $user->name }}" class="avatar avatar-sm rounded-circle">
                                    </a>
                                </div>
                                <div class="col ml-n2">
                                    <span class="text-dark text-sm">{{ __($activity->log_type) }}</span>
                                    <a class="d-block h6 text-sm font-weight-light mb-0">{!! $activity->getRemark() !!}</a>
                                    <small class="d-block">{{$activity->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <hr/>
                <label class="form-control-label mb-4">{{__('Comments')}}</label>
                <div class="list-group list-group-flush mb-0" id="comments">
                    @foreach($task->comments as $comment)
                      @php $user = \App\Models\User::find($comment->user_id); @endphp

                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="#" class="avatar avatar-sm rounded-circle">
                                        <img  data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('assets/img/avatar/avatar-1.png')}}" @endif title="{{ $comment->user->name }}" class="avatar avatar-sm rounded-circle">
                                    </a>
                                </div>
                                <div class="col ml-n2">
                                    <p class="d-block h6 text-sm font-weight-light mb-0 text-break">{{ $comment->comment }}</p>
                                    <small class="d-block">{{$comment->created_at->diffForHumans()}}</small>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="delete-comment" data-url="{{route('comment.destroy',[$task->project_id,$task->id,$comment->id])}}"><i class="fas fa-trash-alt text-danger"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="col-12 d-flex">
                <div class="pr-3">
                    <img data-original-title="{{(!empty(\Auth::user()) ? \Auth::user()->name:'')}}" @if(\Auth::user()->avatar) src="{{asset('/storage/uploads/avatar/'.\Auth::user()->avatar)}}" @else src="{{asset('assets/img/avatar/avatar-1.png')}}" @endif title="{{ Auth::user()->name }}" class="avatar rounded-circle avatar-sm">
                </div>
                <form method="post" class="card-comment-box" id="form-comment" data-action="{{route('comment.store',[$task->project_id,$task->id])}}">
                    <textarea rows="1" class="form-control" name="comment" data-toggle="autosize" placeholder="{{__('Add a comment...')}}"></textarea>
                </form>
            </div>
            <div class="col-12 col-md-12 text-right">
                <div class="actions">
                    <a href="#" id="comment_submit" class="action-item"><i class="fas fa-paper-plane"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('script-page')
<script>
    $(document).ready(function () {
        $(".colorPickSelector").colorPick({
            'onColorSelected': function () {
                var task_id = this.element.parents('.side-modal').attr('id');
                var color = this.color;

                if (task_id) {
                    this.element.css({'backgroundColor': color});
                    $.ajax({
                        url: '{{ route('update.task.priority.color') }}',
                        method: 'PATCH',
                        data: {
                            'task_id': task_id,
                            'color': color,
                        },
                        success: function (data) {
                            $('.task-list-items').find('#' + task_id).attr('style', 'border-left:2px solid ' + color + ' !important');
                        }
                    });
                }
            }
        });
    });
</script>
@endpush
