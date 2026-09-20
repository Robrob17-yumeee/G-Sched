@extends('layouts.app')

@section('title', ' - Submit Feedback')

@section('content')
<div class="feedback-container">
    <div class="feedback-header d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: var(--text-primary); font-weight: 700;">
                <i class="bi bi-chat-text me-2" style="color: var(--medium-blue);"></i>Submit Feedback
            </h1>
            <p class="text-muted mb-0">Please share your experience with your guidance appointment.</p>
        </div>
        <a href="{{ route('student.feedback.index') }}" class="btn btn-outline-secondary" style="min-height: 44px; padding: 0.5rem 1.25rem;">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">
                        Feedback for Appointment
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="appointment-summary card bg-light border mb-4">
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="small text-muted" style="color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Guidance Associate
                                    </div>
                                    <div class="fw-medium" style="color: var(--text-primary);">
                                        {{ $appointment->guidanceAssociate->full_name }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted" style="color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Date & Time
                                    </div>
                                    <div class="fw-medium" style="color: var(--text-primary);">
                                        {{ $appointment->formatted_date }} <span class="text-muted fw-normal">â€¢</span> {{ $appointment->formatted_time }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="small text-muted" style="color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Purpose
                                    </div>
                                    <div class="fw-medium" style="color: var(--text-primary);">
                                        {{ Str::limit($appointment->purpose, 200) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('student.feedback.store') }}">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div id="sqd-error" class="alert alert-danger" style="display: none;">
                            Please answer all SQD questions before submitting your feedback.
                        </div>

                        <div class="sqd-section mb-4">
                            <h4 class="sqd-title mb-2">
                                SERVICE QUALITY DIMENSION (SQD) 0â€“8
                            </h4>
                            <p class="sqd-instruction text-muted mb-4">
                                For SQD 0â€“8, please put a check mark (âœ“) on the column that best corresponds to your answer.
                            </p>

                            <div class="sqd-legend mb-4 d-none d-md-flex justify-content-end gap-2">
                                <span class="sqd-legend-item"><span class="sqd-abbrev">SD</span> = Strongly Disagree</span>
                                <span class="sqd-legend-item"><span class="sqd-abbrev">D</span> = Disagree</span>
                                <span class="sqd-legend-item"><span class="sqd-abbrev">N</span> = Neither Agree nor Disagree</span>
                                <span class="sqd-legend-item"><span class="sqd-abbrev">A</span> = Agree</span>
                                <span class="sqd-legend-item"><span class="sqd-abbrev">SA</span> = Strongly Agree</span>
                                <span class="sqd-legend-item"><span class="sqd-abbrev">N/A</span> = Not Applicable</span>
                            </div>

                            <!-- Desktop Table Layout -->
                            <div class="d-none d-md-block">
                                <div class="sqd-table-responsive">
                                    <table class="table sqd-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sqd-th-question">Question</th>
                                                <th scope="col" class="sqd-th-rating">SD</th>
                                                <th scope="col" class="sqd-th-rating">D</th>
                                                <th scope="col" class="sqd-th-rating">N</th>
                                                <th scope="col" class="sqd-th-rating">A</th>
                                                <th scope="col" class="sqd-th-rating">SA</th>
                                                <th scope="col" class="sqd-th-rating">N/A</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\App\Models\Feedback::SQD_QUESTIONS as $field => $question)
                                                <tr class="sqd-row">
                                                    <td class="sqd-td-question align-middle">
                                                        <span class="sqd-label">{{ strtoupper($field) }}</span>
                                                        <span class="sqd-text">{{ $question }}</span>
                                                    </td>
                                                    <td class="sqd-td-rating text-center align-middle">
                                                        <div class="sqd-radio-wrapper">
                                                            <input type="radio" name="{{ $field }}" value="strongly_disagree" id="{{ $field }}_strongly_disagree" required>
                                                            <label for="{{ $field }}_strongly_disagree" class="sqd-radio-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="sqd-td-rating text-center align-middle">
                                                        <div class="sqd-radio-wrapper">
                                                            <input type="radio" name="{{ $field }}" value="disagree" id="{{ $field }}_disagree" required>
                                                            <label for="{{ $field }}_disagree" class="sqd-radio-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="sqd-td-rating text-center align-middle">
                                                        <div class="sqd-radio-wrapper">
                                                            <input type="radio" name="{{ $field }}" value="neither" id="{{ $field }}_neither" required>
                                                            <label for="{{ $field }}_neither" class="sqd-radio-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="sqd-td-rating text-center align-middle">
                                                        <div class="sqd-radio-wrapper">
                                                            <input type="radio" name="{{ $field }}" value="agree" id="{{ $field }}_agree" required>
                                                            <label for="{{ $field }}_agree" class="sqd-radio-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="sqd-td-rating text-center align-middle">
                                                        <div class="sqd-radio-wrapper">
                                                            <input type="radio" name="{{ $field }}" value="strongly_agree" id="{{ $field }}_strongly_agree" required>
                                                            <label for="{{ $field }}_strongly_agree" class="sqd-radio-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="sqd-td-rating text-center align-middle">
                                                        <div class="sqd-radio-wrapper">
                                                            <input type="radio" name="{{ $field }}" value="not_applicable" id="{{ $field }}_not_applicable" required>
                                                            <label for="{{ $field }}_not_applicable" class="sqd-radio-label"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Mobile Card Layout -->
                            <div class="d-md-none">
                                @foreach(\App\Models\Feedback::SQD_QUESTIONS as $field => $question)
                                    <div class="sqd-mobile-card mb-3">
                                        <div class="sqd-mobile-header">
                                            <span class="sqd-label">{{ strtoupper($field) }}</span>
                                            <p class="sqd-text mb-0">{{ $question }}</p>
                                        </div>
                                        <div class="sqd-options d-grid gap-2 mt-3">
                                            <label class="sqd-option" for="{{ $field }}_strongly_disagree">
                                                <input type="radio" name="{{ $field }}" value="strongly_disagree" id="{{ $field }}_strongly_disagree" required>
                                                <span>Strongly Disagree</span>
                                            </label>
                                            <label class="sqd-option" for="{{ $field }}_disagree">
                                                <input type="radio" name="{{ $field }}" value="disagree" id="{{ $field }}_disagree" required>
                                                <span>Disagree</span>
                                            </label>
                                            <label class="sqd-option" for="{{ $field }}_neither">
                                                <input type="radio" name="{{ $field }}" value="neither" id="{{ $field }}_neither" required>
                                                <span>Neither Agree nor Disagree</span>
                                            </label>
                                            <label class="sqd-option" for="{{ $field }}_agree">
                                                <input type="radio" name="{{ $field }}" value="agree" id="{{ $field }}_agree" required>
                                                <span>Agree</span>
                                            </label>
                                            <label class="sqd-option" for="{{ $field }}_strongly_agree">
                                                <input type="radio" name="{{ $field }}" value="strongly_agree" id="{{ $field }}_strongly_agree" required>
                                                <span>Strongly Agree</span>
                                            </label>
                                            <label class="sqd-option" for="{{ $field }}_not_applicable">
                                                <input type="radio" name="{{ $field }}" value="not_applicable" id="{{ $field }}_not_applicable" required>
                                                <span>N/A â€“ Not Applicable</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="suggestions" class="form-label fw-medium" style="color: var(--text-primary);">
                                Suggestions on how we can further improve our services <span class="text-muted fw-normal">(optional)</span>
                            </label>
                            <textarea class="form-control" id="suggestions" name="suggestions" rows="5"
                                placeholder="Enter your suggestions here..."></textarea>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('student.feedback.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-send me-1"></i>Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .feedback-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .feedback-header h1 {
        font-size: 1.75rem;
    }

    .appointment-summary .card-body {
        padding: 1rem;
    }

    /* SQD Section */
    .sqd-section {
        margin-top: 1.5rem;
    }

    .sqd-title {
        color: var(--text-primary);
        font-size: 1.25rem;
        font-weight: 700;
        border-bottom: 2px solid var(--medium-blue);
        padding-bottom: 0.5rem;
    }

    .sqd-instruction {
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .sqd-legend {
        font-size: 0.75rem;
    }

    .sqd-legend-item {
        color: var(--text-muted);
        font-size: 0.75rem;
    }

    .sqd-abbrev {
        font-weight: 600;
        color: var(--medium-blue);
        margin-right: 0.25rem;
    }

    /* Desktop Table */
    .sqd-table-responsive {
        overflow-x: auto;
    }

    .sqd-table {
        font-size: 0.875rem;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .sqd-table thead th {
        background: var(--bg-light);
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 0.75rem 0.5rem;
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    .sqd-table td {
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .sqd-table tbody tr:last-child td {
        border-bottom: none;
    }

    .sqd-th-question {
        width: 40%!important;
        text-align: left;
    }

    .sqd-th-rating {
        width: 10%;
    }

    .sqd-td-question {
        width: 40%;
    }

    .sqd-td-rating {
        width: 10%;
    }

    .sqd-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--medium-blue);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.25rem;
    }

    .sqd-text {
        display: block;
        color: var(--text-primary);
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .sqd-radio-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .sqd-radio-label {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .sqd-radio-wrapper input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .sqd-radio-wrapper input[type="radio"]:checked + .sqd-radio-label {
        border-color: var(--medium-blue);
        background: var(--medium-blue);
    }

    .sqd-radio-wrapper input[type="radio"]:focus + .sqd-radio-label {
        border-color: var(--medium-blue);
        box-shadow: 0 0 0 3px rgba(66, 158, 189, 0.3);
    }

    .sqd-row:hover .sqd-radio-label {
        border-color: var(--medium-blue);
    }

    /* Mobile Card Layout */
    .sqd-mobile-card {
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1rem;
        background: white;
    }

    .sqd-mobile-header {
        margin-bottom: 0.75rem;
    }

    .sqd-mobile-question p {
        color: var(--text-primary);
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .sqd-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 44px;
    }

    .sqd-option:hover {
        background: rgba(66, 158, 189, 0.1);
        border-color: var(--medium-blue);
    }

    .sqd-option input[type="radio"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--medium-blue);
        margin: 0;
    }

    .sqd-option span {
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    /* Action buttons */
    .btn-primary {
        background: var(--medium-blue);
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        min-height: 44px;
        color: var(--badge-text-light);
    }

    .btn-primary:hover {
        background: var(--navy);
    }

    .btn-outline-secondary {
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        min-height: 44px;
    }
</style>

<script>
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        const sqdFields = ['sqd0', 'sqd1', 'sqd2', 'sqd3', 'sqd4', 'sqd5', 'sqd6', 'sqd7', 'sqd8'];
        let allAnswered = true;
        let unansweredFields = [];

        sqdFields.forEach(function(field) {
            const radios = document.querySelectorAll('input[name="' + field + '"]');
            let answered = false;
            radios.forEach(function(radio) {
                if (radio.checked) {
                    answered = true;
                }
            });
            if (!answered) {
                allAnswered = false;
                unansweredFields.push(field);
            }
        });

        if (!allAnswered) {
            e.preventDefault();
            const errorDiv = document.getElementById('sqd-error');
            errorDiv.style.display = 'block';
            errorDiv.innerHTML = 'Please answer all SQD questions before submitting your feedback. Unanswered: ' + unansweredFields.join(', ');
            window.location.hash = 'sqd-error';
        }
    });
</script>
@endsection
