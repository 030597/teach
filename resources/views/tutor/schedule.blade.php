@extends('layouts.app')

@section('title', 'Manage Schedule - LearnWithExperts')

@section('styles')
<style>
.schedule-day {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    margin-bottom: 20px;
    overflow: hidden;
}

.schedule-day-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 15px;
    cursor: pointer;
}

.schedule-day-content {
    padding: 20px;
    background: #f8f9fa;
}

.time-slot {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.time-slot:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.time-slot.active {
    border-color: #667eea;
    background: #f0f4ff;
}

.slot-checkbox {
    transform: scale(1.2);
}

.day-active {
    border-color: #667eea;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Tutor Menu</h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('tutor.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('profile.tutor') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Tutor Profile
                    </a>
                    <a href="{{ route('tutor.schedule') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-calendar-alt me-2"></i>Manage Schedule
                    </a>
                    <a href="/tutor/students" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i>My Students
                    </a>
                    <a href="/tutor/earnings" class="list-group-item list-group-item-action">
                        <i class="fas fa-dollar-sign me-2"></i>Earnings
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Schedule Stats</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h4 id="totalSlots">0</h4>
                        <p class="small text-muted mb-0">Total Available Slots</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Manage Your Availability</h5>
                    <div>
                        <button class="btn btn-success btn-sm" onclick="selectAllSlots()">
                            <i class="fas fa-check-square me-1"></i>Select All
                        </button>
                        <button class="btn btn-dark btn-sm" onclick="clearAllSlots()">
                            <i class="fas fa-times-circle me-1"></i>Clear All
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="scheduleForm" method="POST" action="{{ route('tutor.schedule.update') }}">
                        @csrf
                        
                        <div class="row" id="scheduleContainer">
                            <!-- Schedule will be loaded here by JavaScript -->
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Schedule
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Instructions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Instructions</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Select the time slots when you're available for teaching</li>
                        <li>Students can only book sessions during your available slots</li>
                        <li>Each slot represents 1 hour of teaching time</li>
                        <li>You can update your schedule anytime</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const days = [
    { name: 'Monday', value: 'monday' },
    { name: 'Tuesday', value: 'tuesday' },
    { name: 'Wednesday', value: 'wednesday' },
    { name: 'Thursday', value: 'thursday' },
    { name: 'Friday', value: 'friday' },
    { name: 'Saturday', value: 'saturday' },
    { name: 'Sunday', value: 'sunday' }
];

const timeSlots = [
    '00:00 - 01:00', '01:00 - 02:00', '02:00 - 03:00', '03:00 - 04:00',
    '04:00 - 05:00', '05:00 - 06:00', '06:00 - 07:00', '07:00 - 08:00',
    '08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00',
    '12:00 - 13:00', '13:00 - 14:00', '14:00 - 15:00', '15:00 - 16:00',
    '16:00 - 17:00', '17:00 - 18:00', '18:00 - 19:00', '19:00 - 20:00',
    '20:00 - 21:00', '21:00 - 22:00', '22:00 - 23:00', '23:00 - 00:00'
];


let selectedSlots = {};

// Initialize schedule
function initializeSchedule() {
    const container = document.getElementById('scheduleContainer');
    
    days.forEach(day => {
        const dayElement = document.createElement('div');
        dayElement.className = 'col-md-6 col-lg-4';
        dayElement.innerHTML = `
            <div class="schedule-day" id="day-${day.value}">
                <div class="schedule-day-header" onclick="toggleDay('${day.value}')">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar-day me-2"></i>${day.name}
                        <span class="badge bg-light text-dark float-end slot-count" id="count-${day.value}">0</span>
                    </h6>
                </div>
                <div class="schedule-day-content">
                    <div class="day-slots" id="slots-${day.value}">
                        ${timeSlots.map(slot => `
                            <div class="time-slot" onclick="toggleSlot('${day.value}', '${slot}')">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input slot-checkbox" 
                                           id="${day.value}-${slot}" name="schedule[${day.value}][slots][]" 
                                           value="${slot}">
                                    <label class="form-check-label" for="${day.value}-${slot}">
                                        ${slot}
                                    </label>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
        container.appendChild(dayElement);
    });

    updateSlotCounts();
}

// Toggle day expansion
function toggleDay(day) {
    const dayElement = document.getElementById(`day-${day}`);
    dayElement.classList.toggle('day-active');
}

// Toggle slot selection
function toggleSlot(day, slot) {
    const checkbox = document.getElementById(`${day}-${slot}`);
    const slotElement = checkbox.closest('.time-slot');
    
    checkbox.checked = !checkbox.checked;
    slotElement.classList.toggle('active', checkbox.checked);
    
    updateSlotCounts();
}

// Update slot counts
function updateSlotCounts() {
    let totalSlots = 0;
    
    days.forEach(day => {
        const checkboxes = document.querySelectorAll(`input[name="schedule[${day.value}][slots][]"]:checked`);
        const countElement = document.getElementById(`count-${day.value}`);
        countElement.textContent = checkboxes.length;
        totalSlots += checkboxes.length;
    });
    
    document.getElementById('totalSlots').textContent = totalSlots;
}

// Select all slots
function selectAllSlots() {
    document.querySelectorAll('.slot-checkbox').forEach(checkbox => {
        checkbox.checked = true;
        checkbox.closest('.time-slot').classList.add('active');
    });
    updateSlotCounts();
}

// Clear all slots
function clearAllSlots() {
    document.querySelectorAll('.slot-checkbox').forEach(checkbox => {
        checkbox.checked = false;
        checkbox.closest('.time-slot').classList.remove('active');
    });
    updateSlotCounts();
}

// Reset form
function resetForm() {
    clearAllSlots();
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeSchedule();
});

// Form submission
document.getElementById('scheduleForm').addEventListener('submit', function(e) {
    const totalSlots = document.getElementById('totalSlots').textContent;
    if (totalSlots === '0') {
        e.preventDefault();
        alert('Please select at least one time slot for your availability.');
        return false;
    }
});
</script>
@endsection