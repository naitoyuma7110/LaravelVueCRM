const nl2br = (str)=> {
    var res = str.replace(/\r\n/g, "<br>");
    res = res.replace(/(\n|\r)/g, "<br>");
    return res;
}

const getToday = () =>{
  const date = new Date();
  const yyyy = date.getFullYear();
  const mm  = ("0"+(date.getMonth() + 1)).slice(-2);
  const dd  = ("0"+(date.getDate())).slice(-2);
  return yyyy+"-"+mm+"-"+dd;
}

export {nl2br, getToday}
