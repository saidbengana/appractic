import{h as x,i as y,bT as S,o as r,c as d,bX as T,a as s,u as l,b as i,w as a,F as f,Z as V,d as n,e as h,t as $}from"./app.c44491d3.js";import{u as U}from"./useNotifications.07ccb338.js";import{_ as z}from"./PageHeader.0b52df6d.js";import{_ as N}from"./Panel.12ea9315.js";import{_ as B}from"./PrimaryButton.b73070c0.js";import{_ as C}from"./Select.412f4a4c.js";import{_ as g}from"./HorizontalGroup.528b8d6f.js";const F=["value"],p={__name:"Radio",props:{checked:{type:[Number,String],default:!1},value:{default:null}},emits:["update:checked"],setup(u,{emit:k}){const e=u,c=x({get(){return e.checked},set(m){k("update:checked",m)}});return(m,_)=>y((r(),d("input",{type:"radio",value:u.value,"onUpdate:modelValue":_[0]||(_[0]=t=>c.value=t),class:"rounded-full w-5 h-5 border-gray-200 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:border-gray-100 disabled:cursor-not-allowed"},null,8,F)),[[S,c.value]])}},D={class:"row-py mb-2xl w-full mx-auto"},M={class:"row-px"},R=["label"],E=["value"],L={class:"flex items-center space-x-sm"},X={class:"flex items-center space-x-sm"},J={__name:"Settings",props:["settings","timezone_list"],setup(u){const e=T(u.settings),{notify:c}=U(),m=()=>{e.put(route("mixpost.settings.update"),{onSuccess(){c("success","Settings have been saved")}})};return(_,t)=>(r(),d(f,null,[s(l(V),{title:"Settings"}),i("div",D,[s(z,{title:"Settings"}),i("div",M,[s(N,null,{title:a(()=>[n("Time settings")]),description:a(()=>[n(" The app will use these settings to display your calendar & analytics. ")]),default:a(()=>[s(g,null,{title:a(()=>[n("Timezone")]),default:a(()=>[i("div",null,[s(C,{modelValue:l(e).timezone,"onUpdate:modelValue":t[0]||(t[0]=o=>l(e).timezone=o)},{default:a(()=>[(r(!0),d(f,null,h(u.timezone_list,(o,v)=>(r(),d("optgroup",{label:v},[(r(!0),d(f,null,h(o,(b,w)=>(r(),d("option",{value:w},$(b),9,E))),256))],8,R))),256))]),_:1},8,["modelValue"])])]),_:1}),s(g,{class:"mt-lg"},{title:a(()=>[n("Time format")]),default:a(()=>[i("div",L,[i("label",null,[s(p,{checked:l(e).time_format,"onUpdate:checked":t[1]||(t[1]=o=>l(e).time_format=o),value:12},null,8,["checked"]),n(" 12 hour")]),i("label",null,[s(p,{checked:l(e).time_format,"onUpdate:checked":t[2]||(t[2]=o=>l(e).time_format=o),value:24},null,8,["checked"]),n(" 24 hour")])])]),_:1}),s(g,{class:"mt-lg"},{title:a(()=>[n("First day of week")]),default:a(()=>[i("div",X,[i("label",null,[s(p,{checked:l(e).week_starts_on,"onUpdate:checked":t[3]||(t[3]=o=>l(e).week_starts_on=o),value:0},null,8,["checked"]),n(" Sunday")]),i("label",null,[s(p,{checked:l(e).week_starts_on,"onUpdate:checked":t[4]||(t[4]=o=>l(e).week_starts_on=o),value:1},null,8,["checked"]),n(" Monday")])])]),_:1}),s(B,{onClick:m,class:"mt-lg"},{default:a(()=>[n("Save settings")]),_:1})]),_:1})])])],64))}};export{J as default};
