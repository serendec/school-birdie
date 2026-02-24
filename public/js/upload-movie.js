window.onload = function() {
    // フォームが存在しない場合は何もしない
    const form = document.querySelector('form.formlist');
    if (!form) return;

    let clickedButtonValue = null;
    // submitボタンに対してクリックイベントを追加
    const submitButtons = form.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            clickedButtonValue = this.value;
        });
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const fileInput = form.querySelector('input[type="file"]');
        const formData = new FormData(form);

        // ボタンがクリックされた場合、post_statusをフォームデータに追加
        if (clickedButtonValue) {
            formData.append('post_status', clickedButtonValue);
        }

        // 動画をアップロードする場合のみ、カスタムアップロード処理を実行
        if (fileInput && fileInput.files.length > 0) {
            const isVideoFile = function(f) {
                return f.type.startsWith('video/')
                    || /\.(mov|mp4|m4v|3gp|avi|mkv|webm)$/i.test(f.name);
            };
            const hasVideo = Array.from(fileInput.files).some(isVideoFile);
            if (hasVideo) {
                const xhr = new XMLHttpRequest();
                const progressBar = document.querySelector('.progress-bar');
                const progressContainer = document.querySelector('.progress');
                const uploadStatus = document.querySelector('.uploadStatus');
                const uploadPercentage = document.querySelector('.uploadPercentage');
                const spinnerContainer = document.querySelector('.spinner-container');
                const loadingIndicator = document.querySelector('.loading-indicator');

                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                        uploadPercentage.innerText = Math.round(percentComplete) + '%';

                        if (percentComplete === 100) {
                            setTimeout(() => {
                                uploadStatus.innerText = '動画処理中...';
                                progressContainer.style.display = 'none';
                                spinnerContainer.style.display = 'flex';
                            }, 1500);
                        }
                    }
                });

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.result === 'error') {
                                uploadStatus.innerText = 'アップロードに失敗しました。時間をおいて再度お試しください。';
                                return;
                            }
                            
                            uploadStatus.innerText = '動画処理完了！自動的にページ遷移します...';

                            // チェックマークを表示
                            loadingIndicator.style.display = 'none';
                            const checkmarkContainer = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                            checkmarkContainer.classList.add('checkmark-container');
                            checkmarkContainer.setAttribute('viewBox', '0 0 64 64');
                            checkmarkContainer.innerHTML = `
                                <circle class="checkmark-circle" cx="32" cy="32" r="25" fill="none" stroke="#34c759" stroke-width="4"/>
                                <path class="checkmark" fill="none" stroke="#34c759" stroke-width="4" d="M20 34 l8 8 l16 -16"/>
                            `;
                            spinnerContainer.appendChild(checkmarkContainer);
                            checkmarkContainer.style.display = 'block';

                            // リダイレクト
                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 3000);
                        } else {
                            // エラーメッセージを表示
                            uploadStatus.innerText = 'アップロードに失敗しました。時間をおいて再度お試しください。';
                        }
                    }
                };

                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.send(formData);

                const modal = document.getElementById('uploadModal');
                if (modal) {
                    modal.style.display = 'block';
                }

                return;
            }
        }

        // post_statusを管理する場合、post_statusをフォームに追加
        if (clickedButtonValue) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'post_status';
            hiddenInput.value = clickedButtonValue;
            form.appendChild(hiddenInput);
        }

        // ビデオファイルが選択されていない場合、通常のフォーム送信を実行
        form.submit();            
    });
};
