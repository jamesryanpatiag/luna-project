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
        <a class="icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);" href="/">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
          <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
        </svg>
          Time-In/Time-Out
        </a>
        |
        <a class="icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -.125rem, 0);" href="{{ route('leavefiling') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
        </svg>
          Leave Filing</a>
      </div>
        <div style="border:0px;background-color:#111828;" class="card shadow rounded-4">
        <img src="{{ asset('images/Logo-luna.png') }}" style="height: 110px;width: 250px; margin: 20px auto -5px auto"/>
        <div style="border:0px;background-color:#111828" class="card-body p-4 rounded-4">
            <h3 style="color: #e2c56d" class="card-title text-center mb-4">Employee Time In / Time Out</h3>
              <div class="mb-3">
                <label style="color: #e2c56d" for="employeeNumber" class="form-label">Employee Number</label>
                <input type="text" class="form-control" wire:model.debounce:500="employeeNumber"placeholder="Enter your employee number">
                @error('employeeNumber') <span class="error">{{ $message }}</span> @enderror
              </div>
              <div class="mb-3">
                <label style="color: #e2c56d" for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" wire:model.debounce:500="lastname" placeholder="Enter your lastname">
                @error('password') <span class="error">{{ $message }}</span> @enderror
              </div>
              <div class="mb-3">
                <label style="color: #e2c56d" for="notes" class="form-label">Notes</label>
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