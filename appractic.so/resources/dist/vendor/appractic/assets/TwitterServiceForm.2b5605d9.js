import{r as _,o as v,k as w,w as e,b as r,a as t,d as i,O as g}from"./app.c44491d3.js";import{u as h}from"./useNotifications.07ccb338.js";import{_ as V}from"./Panel.12ea9315.js";import{_ as u}from"./Input.8b157f00.js";import{T as x}from"./ProviderIcon.f3a99d05.js";import{_ as y}from"./PrimaryButton.b73070c0.js";import{_ as m}from"./HorizontalGroup.528b8d6f.js";import{_ as c}from"./Error.9b01f778.js";import{_ as $}from"./ReadDocHelp.87d14943.js";import{_ as T}from"./Select.412f4a4c.js";const k={class:"flex items-center"},O={class:"mr-xs"},P=r("span",null,"Twitter",-1),b=r("a",{href:"https://developer.twitter.com/en/portal/projects-and-apps",class:"link",target:"_blank"},"Create an App on Twitter",-1),S=r("option",{value:"legacy"},"Legacy",-1),A=r("option",{value:"free"},"Free",-1),B=r("option",{value:"basic"},"Basic",-1),R={__name:"TwitterServiceForm",props:{form:{required:!0,type:Object}},setup(o){const d=o,{notify:f}=h(),s=_({}),p=()=>{s.value={},g.put(route("mixpost.services.update",{service:"twitter"}),d.form,{preserveScroll:!0,onSuccess(){f("success","Twitter credentials have been saved")},onError:n=>{s.value=n}})};return(n,a)=>(v(),w(V,null,{title:e(()=>[r("div",k,[r("span",O,[t(x,{class:"text-twitter"})]),P])]),description:e(()=>[b,i('. You will need to edit the App Permissions and allow "Read and Write". '),t($,{href:`${n.$page.props.mixpost.docs_link}/services/social/x`,class:"mt-xs"},null,8,["href"])]),default:e(()=>[t(m,{class:"mt-lg"},{title:e(()=>[i("API Key")]),footer:e(()=>[t(c,{message:s.value.client_id},null,8,["message"])]),default:e(()=>[t(u,{modelValue:o.form.client_id,"onUpdate:modelValue":a[0]||(a[0]=l=>o.form.client_id=l),error:s.value.hasOwnProperty("client_id"),type:"text",autocomplete:"off"},null,8,["modelValue","error"])]),_:1}),t(m,{class:"mt-lg"},{title:e(()=>[i("API Secret")]),footer:e(()=>[t(c,{message:s.value.client_secret},null,8,["message"])]),default:e(()=>[t(u,{modelValue:o.form.client_secret,"onUpdate:modelValue":a[1]||(a[1]=l=>o.form.client_secret=l),error:s.value.hasOwnProperty("client_secret"),type:"password",autocomplete:"new-password"},null,8,["modelValue","error"])]),_:1}),t(m,{class:"mt-lg"},{title:e(()=>[i("Tier")]),footer:e(()=>[t(c,{message:s.value.environment},null,8,["message"])]),default:e(()=>[t(T,{modelValue:o.form.tier,"onUpdate:modelValue":a[2]||(a[2]=l=>o.form.tier=l),error:s.value.hasOwnProperty("tier"),class:"w-full"},{default:e(()=>[S,A,B]),_:1},8,["modelValue","error"])]),_:1}),t(y,{onClick:p,class:"mt-lg"},{default:e(()=>[i("Save")]),_:1})]),_:1}))}};export{R as default};
