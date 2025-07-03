<div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div>
          @if (session()->has('message'))
              <div class="alert alert-success">
                  {{ session('message') }}
              </div>
          @endif
      </div>
      <div>
          <a href="/">Time-In/Time-Out</a>
          <label style="color: #7b82e3"> | </label>
          <a href="{{ route('leavefiling') }}">Leave Filing</a>
      </div>
        <div style="border:0px;background-color:#111828;" class="card shadow rounded-4">
          <img src="{{ asset('images/Logo.png') }}" style="height: 100px;width: 100px; margin: 20px auto"/>
          <div style="border:0px;background-color:#111828" class="card-body p-4 rounded-4">
            <h3 style="color: #7b82e3" class="card-title text-center mb-4">Employee Leave Form</h3>
              <div class="mb-3">
                <label for="employeeNumber" class="form-label">Employee Number</label>
                <input type="text" class="form-control" wire:model.debounce:500="employeeNumber"placeholder="Enter your employee number">
                @error('employeeNumber') <span class="error">{{ $message }}</span> @enderror
              </div>
              <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" wire:model.debounce:500="lastname" placeholder="Enter your lastname">
                @error('password') <span class="error">{{ $message }}</span> @enderror
              </div>
              <div class="mb-3">
              <label for="lastname" class="form-label">Leave Type</label>
                <select id="leaveTypes" class="form-control" wire:model="leave_type_id">
                    <option value="">Select Leave Type</option>
                    @foreach ($leaveTypes as $key => $leaveType)
                        <option value="{{ $key }}" wire:key="leave_type-{{ $key }}">
                            {{ $leaveType }}</option>
                    @endforeach
                </select>
                @error('leave_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Start Date</label>
                <input type="date" class="form-control" wire:model.debounce:500="start_date">
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">End Date</label>
                <input type="date" class="form-control" wire:model.debounce:500="end_date">
            </div>
              <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <input type="text" class="form-control" wire:model.debounce:500="notes" placeholder="Enter your Notes">
              </div>
              <div class="d-flex justify-content-between">
                <button wire:click="in" class="btn btn-success w-45">Time In</button>
                <button wire:click="out" class="btn btn-danger w-45">Time Out</button>

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>