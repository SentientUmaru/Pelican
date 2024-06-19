<?php

namespace App\Filament\App\Resources\UserResource\Pages;

use App\Filament\App\Resources\UserResource;
use App\Services\Subusers\SubuserCreationService;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('invite')
                ->label('Invite User')
                ->createAnother(false)
                ->form([
                    Grid::make()
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('email')
                                ->email()
                                ->columnSpanFull()
                                ->required()
                                ->unique(),
                            Tabs::make()
                                ->columnSpanFull()
                                ->schema([
                                    Tabs\Tab::make('Console')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.control_desc'))
                                                ->icon('tabler-terminal-2')
                                                ->schema([
                                                    CheckboxList::make('control')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'console' => 'Console',
                                                            'start' => 'Start',
                                                            'stop' => 'Stop',
                                                            'restart' => 'Restart',
                                                            'kill' => 'Kill',
                                                        ])
                                                        ->descriptions([
                                                            'console' => trans('server/users.permissions.control_console'),
                                                            'start' => trans('server/users.permissions.control_start'),
                                                            'stop' => trans('server/users.permissions.control_stop'),
                                                            'restart' => trans('server/users.permissions.control_restart'),
                                                            'kill' => trans('server/users.permissions.control_kill'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('User')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.user_desc'))
                                                ->icon('tabler-users')
                                                ->schema([
                                                    CheckboxList::make('user')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'read' => 'Read',
                                                            'create' => 'Create',
                                                            'update' => 'Update',
                                                            'delete' => 'Delete',
                                                        ])
                                                        ->descriptions([
                                                            'create' => trans('server/users.permissions.user_create'),
                                                            'read' => trans('server/users.permissions.user_read'),
                                                            'update' => trans('server/users.permissions.user_update'),
                                                            'delete' => trans('server/users.permissions.user_delete'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('File')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.file_desc'))
                                                ->icon('tabler-folders')
                                                ->schema([
                                                    CheckboxList::make('file')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'read' => 'Read',
                                                            'read-content' => 'Read Content',
                                                            'create' => 'Create',
                                                            'update' => 'Update',
                                                            'delete' => 'Delete',
                                                            'archive' => 'Archive',
                                                            'sftp' => 'SFTP',
                                                        ])
                                                        ->descriptions([
                                                            'create' => trans('server/users.permissions.file_create'),
                                                            'read' => trans('server/users.permissions.file_read'),
                                                            'read-content' => trans('server/users.permissions.file_read_content'),
                                                            'update' => trans('server/users.permissions.file_update'),
                                                            'delete' => trans('server/users.permissions.file_delete'),
                                                            'archive' => trans('server/users.permissions.file_archive'),
                                                            'sftp' => trans('server/users.permissions.file_sftp'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('Backup')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.backup_desc'))
                                                ->icon('tabler-download')
                                                ->schema([
                                                    CheckboxList::make('backup')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'read' => 'Read',
                                                            'create' => 'Create',
                                                            'delete' => 'Delete',
                                                            'download' => 'Download',
                                                            'restore' => 'Restore',
                                                        ])
                                                        ->descriptions([
                                                            'create' => trans('server/users.permissions.backup_create'),
                                                            'read' => trans('server/users.permissions.backup_read'),
                                                            'delete' => trans('server/users.permissions.backup_delete'),
                                                            'download' => trans('server/users.permissions.backup_download'),
                                                            'restore' => trans('server/users.permissions.backup_restore'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('Allocation')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.allocation_desc'))
                                                ->icon('tabler-network')
                                                ->schema([
                                                    CheckboxList::make('allocation')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'read' => 'Read',
                                                            'create' => 'Create',
                                                            'update' => 'Update',
                                                            'delete' => 'Delete',
                                                        ])
                                                        ->descriptions([
                                                            'read' => trans('server/users.permissions.allocation_read'),
                                                            'create' => trans('server/users.permissions.allocation_create'),
                                                            'update' => trans('server/users.permissions.allocation_update'),
                                                            'delete' => trans('server/users.permissions.allocation_delete'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('Startup')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.startup_desc'))
                                                ->icon('tabler-question-mark')
                                                ->schema([
                                                    CheckboxList::make('startup')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'read' => 'Read',
                                                            'update' => 'Update',
                                                            'docker-image' => 'Docker Image',
                                                        ])
                                                        ->descriptions([
                                                            'read' => trans('server/users.permissions.startup_read'),
                                                            'update' => trans('server/users.permissions.startup_update'),
                                                            'docker-image' => trans('server/users.permissions.startup_docker_image'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('Database')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.database_desc'))
                                                ->icon('tabler-database')
                                                ->schema([
                                                    CheckboxList::make('database')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'read' => 'Read',
                                                            'create' => 'Create',
                                                            'update' => 'Update',
                                                            'delete' => 'Delete',
                                                            'view_password' => 'View Password',
                                                        ])
                                                        ->descriptions([
                                                            'read' => trans('server/users.permissions.database_read'),
                                                            'create' => trans('server/users.permissions.database_create'),
                                                            'update' => trans('server/users.permissions.database_update'),
                                                            'delete' => trans('server/users.permissions.database_delete'),
                                                            'view_password' => trans('server/users.permissions.database_view_password'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('Schedule')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.schedule_desc'))
                                                ->icon('tabler-clock')
                                                ->schema([
                                                    CheckboxList::make('schedule')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'read' => 'Read',
                                                            'create' => 'Create',
                                                            'update' => 'Update',
                                                            'delete' => 'Delete',
                                                        ])
                                                        ->descriptions([
                                                            'read' => trans('server/users.permissions.schedule_read'),
                                                            'create' => trans('server/users.permissions.schedule_create'),
                                                            'update' => trans('server/users.permissions.schedule_update'),
                                                            'delete' => trans('server/users.permissions.schedule_delete'),
                                                        ]),
                                                ]),
                                        ]),
                                    Tabs\Tab::make('Settings')
                                        ->schema([
                                            Section::make()
                                                ->description(trans('server/users.permissions.settings_desc'))
                                                ->icon('tabler-settings')
                                                ->schema([
                                                    CheckboxList::make('settings')
                                                        ->bulkToggleable()
                                                        ->label('')
                                                        ->columns(2)
                                                        ->options([
                                                            'rename' => 'Rename',
                                                            'reinstall' => 'Reinstall',
                                                            'activity' => 'Activity',
                                                        ])
                                                        ->descriptions([
                                                            'rename' => trans('server/users.permissions.setting_rename'),
                                                            'reinstall' => trans('server/users.permissions.setting_reinstall'),
                                                            'activity' => trans('server/users.permissions.setting_activity'),
                                                        ]),
                                                ]),
                                        ]),
                                ]),

                        ]),
                ])
                ->modalHeading('Invite User')
                ->action(function (array $data) {
                    $email = $data['email'];
                    $permissions = collect($data)->forget('email')->map(fn ($permissions, $key) => collect($permissions)->map(fn ($permission) => "$key.$permission"))->flatten()->all();
                    $server = Filament::getTenant();
                    resolve(SubuserCreationService::class)->handle($server, $email, $permissions); // "It's Fine" ~ Lance
                    Notification::make()->title('User Invited!')->success()->send();

                    return redirect()->route('filament.app.resources.users.index', ['tenant' => $server]);
                }),
        ];
    }
}