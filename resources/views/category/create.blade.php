<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Category Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style type="text/css">
    body{
      background: #F8F9FA;
    }
  </style>
</head>
<body>

<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">

            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Create Category</h2>
            <form method="POST" action="{{ route('categories.store') }}">
              @csrf

              @session('error')
                  <div class="alert alert-danger" role="alert">
                      {{ $value }}
                  </div>
              @endsession

              <div class="row gy-2 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="category_name" id="category_name" placeholder="name@example.com" required>
                    <label for="name" class="form-label">{{ __('Category Name') }}</label>
                  </div>
                  @error('name')
                        <span class="text-danger" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="col-12">
<div class="col-12">
  <div class="form-floating mb-3">
    <textarea
      class="form-control @error('description') is-invalid @enderror"
      name="description"
      id="description"
      placeholder="Enter description"  style="height:300px;"
      required>{{ old('description', $category->description ?? '') }}</textarea>
    <label for="description" class="form-label">{{ __('Description') }}</label>
  </div>

  @error('description')
    <span class="text-danger" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>


                <div class="col-12">
                  <div class="d-grid my-3">
                    <button class="btn btn-primary btn-lg" type="submit">{{ __('Add Category') }}</button>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>
