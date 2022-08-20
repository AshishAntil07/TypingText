<?php

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$urlVariables = parse_str(parse_url($url), $params);

if(!($urlVariables['lines'])){
  include_once("Your.html");
}else{
  echo(
    `
      <svg version="1.1" width="100%" xmlns="http://www.w3.org/2000/svg">
        <script>
          const params = new URL(location.href).searchParams;
          alert(params.getAll())
          const text = params.get('text');
          const lines = text.split(' | ');
          const timePerChar = Number(params.get('timePerChar'));
          const rest = Number(params.get('rest'));
          const color = params.get('color');
          let alignment = params.get('alignment');
          const background = params.get('background')?0:'lightgray';
          const family = params.get('family');
          const size = params.get('size');
          alignment.toLowerCase()==='center'?alignment='middle':0;
          let j=0;
          if(text){
            const textElem = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            document.querySelector('svg').append(textElem);
            if(alignment){
              textElem.setAttribute('dominant-baseline', alignment);
              textElem.setAttribute('text-anchor', alignment);
            }
            color?textElem.style.fill = color:0;
            size?textElem.style.fontSize = size:0;
            family?textElem.style.fontFamily = family:0;
            background?textElem.style.background = background:0;
            function lineTyper(line){
              line = lines[j].trim()
              const charInterval = setInterval(() => {
                if(!line[0]){
                  clearInterval(charInterval)
                  setTimeout(e => {
                    const delInterval = setInterval(() => {
                      textElem.innerHTML = textElem.innerHTML.slice(0, textElem.innerHTML.length-1);
                      if(textElem.innerHTML === ''){
                        clearInterval(delInterval);
                        if(!(lines[++j])){
                          j=0;
                          setTimeout(e=>lineTyper(lines[j]), rest)
                        }else{
                          lineTyper(lines[j]);
                        }
                      }
                    }, 20)
                  }, rest);
                }else{
                  textElem.innerHTML += line[0];
                  line = line.slice(1, line.length);
                }
              }, timePerChar)
            }
            lineTyper(lines[j])
          }
        </script>
      </svg>
    `
  )
}

?>
