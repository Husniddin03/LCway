<x-layout>

    <x-slot:title>

        O‘quv markazni tahrirlash - FindCourse

    </x-slot>
    <div class="container">
        <h2>O‘quv markazni tahrirlash</h2>

        <form action="{{ route('course.update', $center->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                @if ($center->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $center->logo) }}" alt="Logo" width="120">
                    </div>
                @endif
                <input type="file" name="logo" id="logo" class="form-control">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nomi</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $center->name }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Turi</label>
                <input type="text" name="type" id="type" class="form-control" value="{{ $center->type }}">
            </div>

            <div class="mb-3">
                <label for="about" class="form-label">Haqida</label>
                <textarea name="about" id="about" class="form-control">{{ $center->about }}</textarea>
            </div>

            <div class="mb-3">
                <label for="province" class="form-label">Viloyat</label>
                <input type="text" name="province" id="province" class="form-control"
                    value="{{ $center->province }}">
            </div>

            <div class="mb-3">
                <label for="region" class="form-label">Tuman</label>
                <input type="text" name="region" id="region" class="form-control" value="{{ $center->region }}">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Manzil</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ $center->address }}">
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location (Google Maps link yoki koordinata)</label>
                <input type="text" name="location" id="location" class="form-control"
                    value="{{ $center->location }}">
            </div>

            <div class="mb-3">
                <label for="usersId" class="form-label">Foydalanuvchi</label>
                <select name="usersId" id="usersId" class="form-select" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $center->usersId == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="studentCount" class="form-label">O‘quvchilar soni</label>
                <input type="number" name="studentCount" id="studentCount" class="form-control"
                    value="{{ $center->studentCount }}">
            </div>

            <button type="submit" class="btn btn-success">Yangilash</button>
            <a href="{{ route('learning-centers.index') }}" class="btn btn-secondary">Bekor qilish</a>
        </form>
    </div>
</x-layout>
