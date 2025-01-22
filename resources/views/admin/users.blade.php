<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="card my-5 p-2" style="background: #f1f1f1;">
        <h2>{{ Auth::user()->username }}'s Only Access</h2>
        <div class="d-flex align-items-center justify-content-end">
            <a href="{{ route('admin.home') }}" class="btn btn-info mr-2" role="button">Back to Dashboard</a>
            <a href="{{ route('logout') }}" class="btn btn-warning">Logout</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>User Role Management System</h4>
        </div>

        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between pb-3">
                <h4>All Users</h4>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr style="background:#b2d5df">
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role ?: 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary mr-2">Edit</a>
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="DELETE" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</body>