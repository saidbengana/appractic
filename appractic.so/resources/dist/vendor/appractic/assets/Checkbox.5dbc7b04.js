import{h as d,i as u,v as l,o as n,c as i}from"./app.c44491d3.js";const p=["value"],k={__name:"Checkbox",props:{checked:{type:[Array,Boolean],default:!1},value:{default:null}},emits:["update:checked"],setup(e,{emit:a}){const c=e,o=d({get(){return c.checked},set(t){a("update:checked",t)}});return(t,r)=>u((n(),i("input",{type:"checkbox",value:e.value,"onUpdate:modelValue":r[0]||(r[0]=s=>o.value=s),class:"rounded-md w-5 h-5 border-gray-200 text-indigo-600 shadow-sm cursor-pointer focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:border-gray-100 disabled:cursor-not-allowed"},null,8,p)),[[l,o.value]])}};export{k as _};
