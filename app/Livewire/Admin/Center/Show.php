<?php

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use App\Models\SubjectsOfLearningCenter;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;
    
    public LearningCenter $center;

    // Teacher edit modal
    public $showTeacherModal = false;
    public $editingTeacher = null;
    public $teacherPhoto;
    public $teacherPhotoPreview = null;
    public $teacherForm = [
        'name' => '',
        'phone' => '',
        'email' => '',
        'bio' => '',
        'subject_id' => '',
        'subject_type' => '',
        'subject_icon' => '',
        'price' => '',
        'currency' => 'so\'m',
        'period' => '',
        'description' => '',
    ];

    // Subject edit modal
    public $showSubjectModal = false;
    public $editingSubject = null;
    public $subjectForm = [
        'subject_name' => '',
        'teacher_id' => '',
        'subject_type' => '',
        'subject_icon' => '',
        'price' => '',
        'currency' => 'so\'m',
        'period' => '',
        'description' => '',
    ];

    // Weekday properties
    public $weekdays = [];
    public $showWeekdayModal = false;
    public $editingWeekday = null;
    public $weekdayForm = [
        'weekdays' => '',
        'open_time' => '',
        'close_time' => '',
    ];

    // Connection properties
    public $showConnectionModal = false;
    public $editingConnection = null;
    public $connectionForm = [
        'connection_name' => '',
        'url' => '',
        'connection_icon' => '',
    ];

    // Image properties
    public $imageFile;
    public $showImageModal = false;
    public $imagePreview = null;

    public function mount(LearningCenter $center)
    {
        $this->center = $center->load([
            'teachers',
            'subjects.teacherSubjects.teacher',
            'comments.user',
            'images',
            'connections',
            'weekdays',
        ]);
        
        // Initialize weekdays array
        $this->initWeekdays();
    }

    public function initWeekdays()
    {
        $allWeekdays = ['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];
        $schedules = $this->center->weekdays ?? collect();
        
        $this->weekdays = collect($allWeekdays)->map(function($day) use ($schedules) {
            $schedule = $schedules->firstWhere('weekdays', $day);
            return [
                'id' => $schedule ? $schedule->id : null,
                'weekdays' => $day,
                'open_time' => $schedule ? $schedule->open_time : null,
                'close_time' => $schedule ? $schedule->close_time : null,
                'exists' => $schedule ? true : false,
            ];
        })->toArray();
    }

    // Weekday methods
    public function editWeekday($dayName)
    {
        $weekday = collect($this->weekdays)->firstWhere('weekdays', $dayName);
        if ($weekday && $weekday['exists']) {
            $this->editingWeekday = $weekday['id'];
            $this->weekdayForm = [
                'weekdays' => $weekday['weekdays'],
                'open_time' => $weekday['open_time'],
                'close_time' => $weekday['close_time'],
            ];
            $this->showWeekdayModal = true;
        }
    }

    public function addWeekday($dayName)
    {
        $this->editingWeekday = null;
        $this->weekdayForm = [
            'weekdays' => $dayName,
            'open_time' => '',
            'close_time' => '',
        ];
        $this->showWeekdayModal = true;
    }

    public function saveWeekday()
    {
        $this->validate([
            'weekdayForm.weekdays' => 'required|string|max:255',
            'weekdayForm.open_time' => 'nullable',
            'weekdayForm.close_time' => 'nullable',
        ]);

        $data = [
            'learning_centers_id' => $this->center->id,
            'weekdays' => $this->weekdayForm['weekdays'],
            'open_time' => $this->weekdayForm['open_time'] ?: null,
            'close_time' => $this->weekdayForm['close_time'] ?: null,
        ];

        if ($this->editingWeekday) {
            \App\Models\LearningCentersCalendar::find($this->editingWeekday)->update($data);
            session()->flash('message', 'Ish kuni yangilandi.');
        } else {
            \App\Models\LearningCentersCalendar::create($data);
            session()->flash('message', 'Ish kuni qo\'shildi.');
        }

        $this->showWeekdayModal = false;
        $this->editingWeekday = null;
        $this->center->load('weekdays');
        $this->initWeekdays();
    }

    public function deleteWeekday($scheduleId)
    {
        $schedule = \App\Models\LearningCentersCalendar::find($scheduleId);
        if ($schedule) {
            $schedule->delete();
            $this->center->load('weekdays');
            $this->initWeekdays();
            session()->flash('message', 'Ish kuni o\'chirildi.');
        }
    }

    public function closeWeekdayModal()
    {
        $this->showWeekdayModal = false;
        $this->editingWeekday = null;
    }

    // Teacher methods
    public function createTeacher()
    {
        $this->editingTeacher = null;
        $this->teacherPhoto = null;
        $this->teacherPhotoPreview = null;
        $this->teacherForm = [
            'name' => '',
            'phone' => '',
            'email' => '',
            'bio' => '',
            'subject_id' => '',
            'subject_type' => '',
            'subject_icon' => '',
            'price' => '',
            'currency' => 'so\'m',
            'period' => '',
            'description' => '',
        ];
        $this->showTeacherModal = true;
    }

    public function editTeacher($teacherId)
    {
        $this->editingTeacher = Teacher::find($teacherId);
        $teacherSubject = $this->editingTeacher->teacherSubjects->first();
        
        $this->teacherPhoto = null;
        $this->teacherPhotoPreview = $this->editingTeacher->photo ? asset('storage/' . $this->editingTeacher->photo) : null;
        $this->teacherForm = [
            'name' => $this->editingTeacher->name,
            'phone' => $this->editingTeacher->phone ?? '',
            'email' => $this->editingTeacher->email ?? '',
            'bio' => $this->editingTeacher->bio ?? '',
            'subject_id' => $teacherSubject?->subject_id ?? '',
            'subject_type' => $teacherSubject?->subject_type ?? '',
            'subject_icon' => $teacherSubject?->subject_icon ?? '',
            'price' => $teacherSubject?->price ?? '',
            'currency' => $teacherSubject?->currency ?? 'so\'m',
            'period' => $teacherSubject?->period ?? '',
            'description' => $teacherSubject?->description ?? '',
        ];
        $this->showTeacherModal = true;
    }

    public function updatedTeacherPhoto()
    {
        $this->validate([
            'teacherPhoto' => 'image|max:2048',
        ]);
        $this->teacherPhotoPreview = $this->teacherPhoto->temporaryUrl();
    }

    public function saveTeacher()
    {
        $this->validate([
            'teacherForm.name' => 'required|string|max:255',
            'teacherForm.phone' => 'nullable|string|max:255',
            'teacherForm.email' => 'nullable|email|max:255',
            'teacherForm.bio' => 'nullable|string',
            'teacherForm.subject_id' => 'nullable|exists:subjects_of_learning_centers,id',
            'teacherForm.subject_type' => 'nullable|string|max:255',
            'teacherForm.subject_icon' => 'nullable|string|max:255',
            'teacherForm.price' => 'nullable|integer',
            'teacherForm.currency' => 'nullable|string|max:50',
            'teacherForm.period' => 'nullable|string|max:50',
            'teacherForm.description' => 'nullable|string',
        ]);

        $teacherData = [
            'name' => $this->teacherForm['name'],
            'phone' => $this->teacherForm['phone'] ?: null,
            'email' => $this->teacherForm['email'] ?: null,
            'bio' => $this->teacherForm['bio'] ?: null,
        ];

        // Handle photo upload
        if ($this->teacherPhoto) {
            $path = $this->teacherPhoto->store('uploads/teachers', 'public');
            $teacherData['photo'] = $path;
            
            // Delete old photo if editing
            if ($this->editingTeacher && $this->editingTeacher->photo) {
                if (\Storage::exists('public/' . $this->editingTeacher->photo)) {
                    \Storage::delete('public/' . $this->editingTeacher->photo);
                }
            }
        }

        if ($this->editingTeacher) {
            $this->editingTeacher->update($teacherData);
            $teacher = $this->editingTeacher;
            $message = 'O\'qituvchi yangilandi.';
        } else {
            $teacherData['learning_centers_id'] = $this->center->id;
            $teacher = Teacher::create($teacherData);
            $message = 'O\'qituvchi qo\'shildi.';
        }

        // Handle subject assignment
        if (!empty($this->teacherForm['subject_id'])) {
            \App\Models\TeacherSubject::updateOrCreate(
                ['teacher_id' => $teacher->id],
                [
                    'subject_id' => $this->teacherForm['subject_id'],
                    'subject_type' => $this->teacherForm['subject_type'] ?: null,
                    'subject_icon' => $this->teacherForm['subject_icon'] ?: null,
                    'price' => $this->teacherForm['price'] ?: null,
                    'currency' => $this->teacherForm['currency'] ?: null,
                    'period' => $this->teacherForm['period'] ?: null,
                    'description' => $this->teacherForm['description'] ?: null,
                ]
            );
        } else {
            // Remove existing relation if no subject selected
            $teacher->teacherSubjects()->delete();
        }

        $this->showTeacherModal = false;
        $this->editingTeacher = null;
        $this->teacherPhoto = null;
        $this->teacherPhotoPreview = null;
        $this->center->load('teachers.teacherSubjects.subject');
        session()->flash('message', $message);
    }

    public function closeTeacherModal()
    {
        $this->showTeacherModal = false;
        $this->editingTeacher = null;
        $this->teacherPhoto = null;
        $this->teacherPhotoPreview = null;
    }

    public function deleteTeacher($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            // Delete photo from storage
            if ($teacher->photo && \Storage::exists('public/' . $teacher->photo)) {
                \Storage::delete('public/' . $teacher->photo);
            }
            $teacher->delete();
            $this->center->load('teachers');
            session()->flash('message', 'O\'qituvchi o\'chirildi.');
        }
    }

    // Subject methods
    public function createSubject()
    {
        $this->editingSubject = null;
        $this->subjectForm = [
            'subject_name' => '',
            'teacher_id' => '',
            'subject_type' => '',
            'subject_icon' => '',
            'price' => '',
            'currency' => 'so\'m',
            'period' => '',
            'description' => '',
        ];
        $this->showSubjectModal = true;
    }

    public function editSubject($subjectId)
    {
        $this->editingSubject = SubjectsOfLearningCenter::find($subjectId);
        $teacherSubject = $this->editingSubject->teacherSubjects->first();
        
        $this->subjectForm = [
            'subject_name' => $this->editingSubject->subject_name,
            'teacher_id' => $teacherSubject?->teacher_id ?? '',
            'subject_type' => $teacherSubject?->subject_type ?? '',
            'subject_icon' => $teacherSubject?->subject_icon ?? '',
            'price' => $teacherSubject?->price ?? '',
            'currency' => $teacherSubject?->currency ?? 'so\'m',
            'period' => $teacherSubject?->period ?? '',
            'description' => $teacherSubject?->description ?? '',
        ];
        $this->showSubjectModal = true;
    }

    public function saveSubject()
    {
        $this->validate([
            'subjectForm.subject_name' => 'required|string|max:255',
            'subjectForm.teacher_id' => 'nullable|exists:teachers,id',
            'subjectForm.subject_type' => 'nullable|string|max:255',
            'subjectForm.subject_icon' => 'nullable|string|max:255',
            'subjectForm.price' => 'nullable|integer',
            'subjectForm.currency' => 'nullable|string|max:50',
            'subjectForm.period' => 'nullable|string|max:50',
            'subjectForm.description' => 'nullable|string',
        ]);

        if ($this->editingSubject) {
            $this->editingSubject->update(['subject_name' => $this->subjectForm['subject_name']]);
            $subject = $this->editingSubject;
            $message = 'Fan yangilandi.';
        } else {
            $subject = SubjectsOfLearningCenter::create([
                'learning_centers_id' => $this->center->id,
                'subject_name' => $this->subjectForm['subject_name'],
            ]);
            $message = 'Fan qo\'shildi.';
        }

        // Handle teacher assignment
        if (!empty($this->subjectForm['teacher_id'])) {
            \App\Models\TeacherSubject::updateOrCreate(
                ['subject_id' => $subject->id],
                [
                    'teacher_id' => $this->subjectForm['teacher_id'],
                    'subject_type' => $this->subjectForm['subject_type'] ?: null,
                    'subject_icon' => $this->subjectForm['subject_icon'] ?: null,
                    'price' => $this->subjectForm['price'] ?: null,
                    'currency' => $this->subjectForm['currency'] ?: null,
                    'period' => $this->subjectForm['period'] ?: null,
                    'description' => $this->subjectForm['description'] ?: null,
                ]
            );
        } else {
            // Remove existing relation if no teacher selected
            $subject->teacherSubjects()->delete();
        }

        $this->showSubjectModal = false;
        $this->editingSubject = null;
        $this->center->load('subjects.teacherSubjects.teacher');
        session()->flash('message', $message);
    }

    public function closeSubjectModal()
    {
        $this->showSubjectModal = false;
        $this->editingSubject = null;
    }

    public function deleteSubject($subjectId)
    {
        $subject = SubjectsOfLearningCenter::find($subjectId);
        if ($subject) {
            $subject->delete();
            $this->center->load('subjects.teacherSubjects');
            session()->flash('message', 'Fan o\'chirildi.');
        }
    }

    // Comment methods
    public function toggleComment($commentId)
    {
        $comment = \App\Models\LearningCentersComment::find($commentId);
        if ($comment) {
            $comment->update(['checked' => !$comment->checked]);
            $this->center->load('comments.user');
            $status = $comment->checked ? 'tasdiqlandi' : 'rad etildi';
            session()->flash('message', "Izoh {$status}.");
        }
    }

    public function approveComment($commentId)
    {
        $comment = \App\Models\LearningCentersComment::find($commentId);
        if ($comment) {
            $comment->update(['checked' => true]);
            $this->center->load('comments.user');
            session()->flash('message', 'Izoh tasdiqlandi.');
        }
    }

    public function rejectComment($commentId)
    {
        $comment = \App\Models\LearningCentersComment::find($commentId);
        if ($comment) {
            $comment->update(['checked' => false]);
            $this->center->load('comments.user');
            session()->flash('message', 'Izoh rad etildi.');
        }
    }

    public function deleteComment($commentId)
    {
        $comment = \App\Models\LearningCentersComment::find($commentId);
        if ($comment) {
            $comment->delete();
            $this->center->load('comments.user');
            session()->flash('message', 'Izoh o\'chirildi.');
        }
    }

    // Connection methods
    public function createConnection()
    {
        $this->editingConnection = null;
        $this->connectionForm = [
            'connection_name' => '',
            'url' => '',
            'connection_icon' => '',
        ];
        $this->showConnectionModal = true;
    }

    public function editConnection($connectionId)
    {
        $connection = \App\Models\LearningCentersConnect::find($connectionId);
        if ($connection) {
            $this->editingConnection = $connectionId;
            $this->connectionForm = [
                'connection_name' => $connection->connection_name,
                'url' => $connection->url,
                'connection_icon' => $connection->connection_icon ?? '',
            ];
            $this->showConnectionModal = true;
        }
    }

    public function saveConnection()
    {
        $this->validate([
            'connectionForm.connection_name' => 'required|string|max:255',
            'connectionForm.url' => 'required|string|max:500',
            'connectionForm.connection_icon' => 'nullable|string|max:50',
        ]);

        $data = [
            'learning_centers_id' => $this->center->id,
            'connection_name' => $this->connectionForm['connection_name'],
            'url' => $this->connectionForm['url'],
            'connection_icon' => $this->connectionForm['connection_icon'] ?: null,
        ];

        if ($this->editingConnection) {
            \App\Models\LearningCentersConnect::find($this->editingConnection)->update($data);
            session()->flash('message', 'Bog\'lanish yangilandi.');
        } else {
            \App\Models\LearningCentersConnect::create($data);
            session()->flash('message', 'Bog\'lanish qo\'shildi.');
        }

        $this->showConnectionModal = false;
        $this->editingConnection = null;
        $this->center->load('connections');
    }

    public function deleteConnection($connectionId)
    {
        $connection = \App\Models\LearningCentersConnect::find($connectionId);
        if ($connection) {
            $connection->delete();
            $this->center->load('connections');
            session()->flash('message', 'Bog\'lanish o\'chirildi.');
        }
    }

    public function closeConnectionModal()
    {
        $this->showConnectionModal = false;
        $this->editingConnection = null;
    }

    // Image methods
    public function openImageModal()
    {
        $this->imageFile = null;
        $this->imagePreview = null;
        $this->showImageModal = true;
    }

    public function updatedImageFile()
    {
        $this->validate([
            'imageFile' => 'image|max:2048', // 2MB max
        ]);
        
        $this->imagePreview = $this->imageFile->temporaryUrl();
    }

    public function saveImage()
    {
        $this->validate([
            'imageFile' => 'required|image|max:2048',
        ]);

        $path = $this->imageFile->store('uploads/centers', 'public');

        $this->center->images()->create([
            'image' => $path,
        ]);

        $this->center->load('images');
        $this->closeImageModal();
        session()->flash('message', 'Rasm muvaffaqiyatli qo\'shildi.');
    }

    public function deleteImage($imageId)
    {
        $image = \App\Models\LearningCentersImage::find($imageId);
        if ($image) {
            // Delete file from storage
            if (\Storage::exists('public/' . $image->image)) {
                \Storage::delete('public/' . $image->image);
            }
            $image->delete();
            $this->center->load('images');
            session()->flash('message', 'Rasm o\'chirildi.');
        }
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->imageFile = null;
        $this->imagePreview = null;
    }

    public function toggleCenterChecked()
    {
        $this->center->update(['checked' => !$this->center->checked]);
        $this->center->refresh();
        $status = $this->center->checked ? 'tasdiqlandi' : 'rad etildi';
        session()->flash('message', "O'quv markaz {$status}.");
    }

    public function toggleCenterPremium()
    {
        $this->center->update(['premium' => !$this->center->premium]);
        $this->center->refresh();
        $status = $this->center->premium ? 'premium' : 'premium emas';
        session()->flash('message', "O'quv markaz {$status} holatiga o'tkazildi.");
    }

    public function render()
    {
        return view('livewire.admin.center.show', [
            'center' => $this->center,
        ])->layout('layouts.admin.app', ['title' => $this->center->name]);
    }
}
