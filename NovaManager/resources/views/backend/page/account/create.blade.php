<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary-rgba add_role_none" data-toggle="modal"
            data-target="#exampleModalCenter"><i class="feather icon-plus mr-2"></i>Thêm tài khoản</button>
        <!-- Modal -->
        <div class="modal fade text-left" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Thêm thông tin tài khoản </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add__acount" action="{{ route('account.create') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="appointno">Tài khoản đăng nhập :</label>
                                    <input id="username" type="text" class="form-control" name="username"
                                        placeholder="Nhập email">
                                    <p class="text-danger" id="mess_username"></p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="appointpatient">Mật khẩu :</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control" name="password"
                                            placeholder="Mật khẩu">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="togglePassword">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-danger" id="mess_password"></p>
                                </div>

                                <script>
                                    const passwordInput = document.getElementById('password');
                                    const togglePasswordButton = document.getElementById('togglePassword');

                                    togglePasswordButton.addEventListener('click', function() {
                                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                        passwordInput.setAttribute('type', type);

                                        // Toggle the eye icon
                                        const eyeIcon = togglePasswordButton.querySelector('i');
                                        eyeIcon.classList.toggle('fa-eye');
                                        eyeIcon.classList.toggle('fa-eye-slash');
                                    });
                                </script>

                                <div class="form-group col-md-12">
                                    <label for="appointdoctor">Nhập lại mật khẩu :</label>
                                    <div class="input-group">
                                        <input id="password__again" type="password" class="form-control"
                                            placeholder="Nhập lại mật khẩu">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="togglePasswordAgain">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-danger" id="mess_password_again"></p>
                                </div>

                                <script>
                                    const passwordAgainInput = document.getElementById('password__again');
                                    const togglePasswordAgainButton = document.getElementById('togglePasswordAgain');

                                    togglePasswordAgainButton.addEventListener('click', function() {
                                        const type = passwordAgainInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                        passwordAgainInput.setAttribute('type', type);

                                        // Toggle the eye icon
                                        const eyeIcon = togglePasswordAgainButton.querySelector('i');
                                        eyeIcon.classList.toggle('fa-eye');
                                        eyeIcon.classList.toggle('fa-eye-slash');
                                    });
                                </script>

                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="appointpaystatus">Phòng ban</label>
                                    <select id="appointpaystatus" name="dept" class="form-control">
                                        @foreach ($getDept as $item)
                                            <option value="{{ $item->dept_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="appointpaystatus">Chức vụ</label>
                                    <select id="appointpaystatus" name="pos" class="form-control">
                                        @foreach ($getPos as $item)
                                            <option value="{{ $item->pos_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btn_addacount" type="submit" class="btn btn-primary"><i
                                        class="feather icon-plus mr-2"></i>Thêm tài khoản</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const btn_addacount = document.getElementById('btn_addacount');
    btn_addacount.addEventListener('click', function(event) {
        const formAddAccount = document.getElementById('add__acount');
        event.preventDefault();
        var check = true;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const passwordAgain = document.getElementById('password__again').value;

        if (!(/\S+@\S+\.\S+/.test(username))) {
            document.getElementById('mess_username').textContent = "*Email không chính xác (example@xxx.com)";
            check = false;
        } else {
            document.getElementById('mess_username').textContent = "";
        }

        if (!password) {
            document.getElementById('mess_password').textContent = "Bạn chưa điền mật khẩu";
            check = false;
        } else if (!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password))) {
            // Ít nhất 8 ký tự, ít nhất một chữ số, ít nhất một chữ thường, ít nhất một chữ hoa
            document.getElementById('mess_password').textContent = "Mật khẩu Ít nhất 8 ký tự, ít nhất một chữ số, ít nhất một chữ thường, ít nhất một chữ hoa";
            check = false;
        } else {
            document.getElementById('mess_password').textContent = "";
        }
        if (password !== passwordAgain) {
            document.getElementById('mess_password_again').textContent = "Mật khẩu không trùng khớp";
            check = false;
        } else {
            document.getElementById('mess_password_again').textContent = "";
        }
        if (!check)
            return;

        formAddAccount.submit();
    });
</script>
