document.addEventListener( 'wpcf7mailsent', function (event) {

    const adminAjax = bgpLocalizedScript.ajax_url;
    const bgpAction = bgpLocalizedScript.action;
    const bgpNonce = bgpLocalizedScript.nonce;

    const data = new FormData();
    data.append('action', bgpAction);
    data.append('nonce', bgpNonce);

    fetch(adminAjax + '?action='+bgpAction+'&nonce='+bgpNonce, {
        method: 'POST',
        credentials: 'same-origin',
        mode: 'cors',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    }).then((response)=>response.json()).then((d)=>{
        console.log(d)
    }).catch((error)=>{
        console.log(error);
    });

}, false );

