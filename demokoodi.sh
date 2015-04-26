for i in app/**/*.{php,html}; do vim --cmd 'set t_ti= t_te=' +redraw +q "$i";sleep 10;done
