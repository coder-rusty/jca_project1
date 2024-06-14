@extends('layout.eventLayout')

@section('eventContent')

<div class="form-container">
    <h1>Contestant Registration Form</h1>
    <form method="post" action="{{ route('contestant.create') }}" enctype="multipart/form-data">
        @csrf
        @method('post')
        <div class="modal-body">

            <div class="mb-3">
                <label for="name" class="form-label">Contestant Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name here" name="name" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" placeholder="Enter address here" name="address" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" required>
            </div>

            <div class="mb-3">
                <label for="contestantNum" class="form-label">Number</label>
                <input type="number" class="form-control" id="contestantNum" placeholder="Enter number here" name="contestantNum" required>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" placeholder="Enter age here" name="age" required>
            </div>

            <div class="mb-3">
                <label for="chest" class="form-label">Chest</label>
                <input type="number" class="form-control" id="chest" placeholder="Enter chest measurement here" name="chest" required>
            </div>

            <div class="mb-3">
                <label for="waist" class="form-label">Waist</label>
                <input type="number" class="form-control" id="waist" placeholder="Enter waist measurement here" name="waist" required>
            </div>

            <div class="mb-3">
                <label for="height" class="form-label">Height</label>
                <input type="number" class="form-control" id="height" placeholder="Enter height here" name="height" required>
            </div>

            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" class="form-control" id="weight" placeholder="Enter weight here" name="weight" required>
            </div>

            <div class="mb-3">
                <label for="hips" class="form-label">Hips</label>
                <input type="number" class="form-control" id="hips" placeholder="Enter hips measurement here" name="hips" required>
            </div>

            <input type="hidden" class="form-control" name="eventID" value="{{ $event->id }}">

        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
</div>

@endsection


<style>
.form-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-sizing: border-box;
}

.btn-primary {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>