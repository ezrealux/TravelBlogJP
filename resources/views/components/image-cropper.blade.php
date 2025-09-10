@props([
    'name' => 'image',    // input name
    'label' => '上傳圖片', // 顯示標題
    'aspect' => 1,        // 裁切比例 (預設 1:1)
    'preview' => null     // 初始預覽圖
])

<div class="mb-3">
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
    <!-- partial: 適合無邏輯的html view, component: 適合有邏輯可重用的ui -->
    <label for="{{ $name }}Input" class="form-label">{{ $label }}</label>
    <input type="file" class="form-control" id="{{ $name }}Input" name="{{ $name }}">

    <div class="mt-3 d-flex justify-content-center">
        <div style="width: 300px; height: 300px; border: 1px solid #ccc; border-radius: 8px; overflow: hidden;">
            <img id="{{ $name }}Preview"
                 src="{{ $preview ? asset($preview) : '' }}"
                 style="max-width: 100%; display: {{ $preview ? 'block' : 'none' }};">
        </div>
    </div>

    <input type="hidden" name="{{ $name }}_cropped" id="{{ $name }}Cropped">
</div>

@push('scripts')
<script>
    (function(){
        let cropper{{ ucfirst($name) }};
        const input = document.getElementById('{{ $name }}Input');
        const preview = document.getElementById('{{ $name }}Preview');
        const croppedInput = document.getElementById('{{ $name }}Cropped');

        input.addEventListener('change', (e) => { // input的值改變時觸發事件(有人上傳圖片檔)
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) { // 上傳的檔案讀取完成後進入function
                preview.src = event.target.result;
                preview.style.display = 'block';

                if (cropper{{ ucfirst($name) }}) cropper{{ ucfirst($name) }}.destroy();

                cropper{{ ucfirst($name) }} = new Cropper(preview, {
                    aspectRatio: {{ $aspect }},
                    viewMode: 1,
                    autoCropArea: 1,
                    responsible: true,
                    zoomable: true,
                    movable: true,
                    background: false
                });
            };
            reader.readAsDataURL(file);

        });

        const form = document.getElementById('ProfileEditForm');
        form.addEventListener('submit', function () {
            if (cropper{{ ucfirst($name) }}) {
                const canvas = cropper{{ ucfirst($name) }}.getCroppedCanvas({
                    width: 400,
                    height: 400,
                });
                croppedInput.value = canvas.toDataURL('image/png');
            }
        });
    })();
</script>
@endpush
