
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showToastMessage(type = "success", message = "", timer = 3000, didClose = undefined, position = 'top-end') {
        return Swal.fire({
            toast: true,
            icon: type,
            title: message,
            position: position,
            showConfirmButton: false,
            timer: timer,
            didClose: didClose
        })
    }
    function showPopupMessage(type = "success", message = "", didClose = undefined, text = "") {
        return Swal.fire({
            icon: type,
            title: message,
            showConfirmButton: true,
            didClose: didClose,
            html: text
        })
    }

    function confirmationDialog(title = "") {
        return Swal.fire({
            title: title,
            showDenyButton: true,
            denyButtonText: "Tidak",
            confirmButtonText: "Ya"
        })
    }

    $(window).on('load', function() {
        <?php 
            if(session()->has('danger')):
        ?>
                showPopupMessage('error', "<?= session('danger') ?>")
        <?php
            endif;
        ?>

        <?php 
            if(session()->has('success')):
        ?>
                showPopupMessage('success', "<?= session('success') ?>")
        <?php
            endif;
        ?>
    })
//   let baseUrl = "<?= url('/') ?>"
  let baseUrl = `${window.location.protocol}//${window.location.host}`
  async function makeRequestToServer(path, method, withRefresh = false, formData = null) {
    try {
        let response;
        if(withRefresh) {
            response = await fetch(`${baseUrl}/api/refresh-token`, {
                method: "GET",
            })
            if(response.ok) {
                if(formData == null) {
                    response = await fetch(`${baseUrl}${path}`, {
                        method: method
                    })
                }
                else {
                    response = await fetch(`${baseUrl}${path}`, {
                        method: method,
                        body: formData
                    })
                }
            }
            else {
                window.location.href = '/login'
                return false
            }
        }
        else {
            response = await fetch(`${baseUrl}${path}`, {
                method: method,
                body: formData
            })
        }
        if(response.status == '400') {
            let result = await response.json()
            let message = "<ol>"
            Object.keys(result['message']).forEach((key) => {
                message += `<li class="mb-0 text-left">${result['message'][key]}</li>`
            })
            message += "</ol>"
            showPopupMessage('warning', "Input Error", undefined, message)
            return false
        }
        return response
    } catch (error) {
        showToastMessage('error', 'Request ke server error')
        return false
    }
  }
</script>