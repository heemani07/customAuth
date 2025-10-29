# TODO: Fix Edit and Delete Functionality

- [x] Update UserController.php: Change parameters from $users to $user, fix validation rule 'password'=>'required|min:6' to 'nullable|min:6', hash password on update
- [x] Update user.blade.php: Change @foreach loop variable from $task to $user
- [x] Update edit.blade.php: Change form action to route('users.update', $user->id), add @method('PUT'), fix value attributes to use old('field', $user->field), make password fields optional, remove password_confirmation field
