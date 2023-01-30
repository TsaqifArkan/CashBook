function rupiah(n){
    t = '';
    while(n > 999){
        t = '.' + String(n%1000).padStart(3, 0) + t;
        n = Math.floor(n/1000);
    };

    return 'Rp '+n+t+',00';
}