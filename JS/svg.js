const params = new URL(location.href).searchParams;
const text = params.get('text')?params.get('text'):'Hello there!';
const lines = text.split(' | ');
const timePerChar = Number(params.get('timePerChar'))?Number(params.get('timePerChar')):100;
const rest = Number(params.get('rest'))?Number(params.get('rest')):1000;
const color = params.get('color')?params.get('color'):'gray';
let alignment = params.get('alignment')?params.get('alignment'):'left';
const background = params.get('background')?params.get('background'):'transparent';
const family = params.get('family')?params.get('family'):monospace;
const size = params.get('size')?params.get('size'):20;
let j=0;

if(text){
  const textElem = document.createElementNS('http://www.w3.org/2000/svg', 'text');
  alignment.toLowerCase()==='center'?alignment='middle':0;
  document.querySelector('svg').append(textElem);

  textElem.setAttribute('dominant-baseline', alignment);
  textElem.setAttribute('text-anchor', alignment);
  alignment==='middle'?textElem.style.transform = 'translate(50%, 20px)':textElem.style.transform = 'translate(0px, 20px)';

  textElem.style.fill = color:0;
  textElem.style.fontSize = size:0;
  textElem.style.fontFamily = family:0;
  textElem.style.background = background:0;

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
      
  document.replaceChild(document.querySelector('svg'), document.documentElement);
  lineTyper(lines[j])
}
