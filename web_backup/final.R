library("methods")
library("jiebaRD")
library("jiebaR")
library("stringr")
library("quanteda")
library("readr")

args <- commandArgs(TRUE)
n <- args[1]
require("methods")
n=as.numeric(n)
if(n>=10){
  ZOA=read.csv("/home/opendata2/R_needuse_data/1126_final_gui0.csv",stringsAsFactors = FALSE)
}else{
  ZOA=read.csv("/home/opendata2/R_needuse_data/1126_final_zoa2.csv",stringsAsFactors = FALSE)#,fileEncoding = "UTF-8",encoding = "GBK")
}
require(jiebaR)
seg<-worker(symbol = T, bylines = T,user = "/home/opendata2/R_needuse_data/1128NEW_WORD.txt",stop_word = "/home/opendata2/R_needuse_data/stopwordsCN.txt")
segWords=segment(ZOA[,3], seg)
WS=read.csv("/home/opendata2/R_needuse_data/finaltoken_1127new0.csv",stringsAsFactors = FALSE)
WS=WS[,3:11]
for(i in 1:length(segWords)){
  maprow=7
  # find map row
  for(j in 1:length(segWords[[i]])){
    gg=which(segWords[[i]][j]==WS[,1])
    maprow=c(maprow,gg)
  }
  maprow=maprow[-1]
  if(length(maprow)==1){
    TMF1=WS[maprow,2:9]
  }else if(length(maprow)>1){
    TT=WS[maprow,]
    TMF1=7
    for(c in 2:9){
      have=length(which(TT[,c]==1))
      nohave=length(which(TT[,c]==0))
      if(have>nohave){
        TMF1=c(TMF1,1)
      }else{
        TMF1=c(TMF1,0)
      }
    }
    TMF1=TMF1[-1]
  }else{TMF1=c(7,7,7,7,7,7,7,7)}# no word in dictionary
  if(i==1){
    TMF=TMF1 #((when i=1
  }else{
    TMF=rbind(TMF,TMF1)
    if(i==2){
      TMF=as.data.frame(TMF)
      colnames(TMF)=c("i","e","n","s","t","f","j","p")
    }
  }
}

finaltype=7
for(d in 1:8){
  if(length(which(TMF[,d]==1))>length(which(TMF[,d]==0))){
    finaltype=c(finaltype,1)
  }else{
    finaltype=c(finaltype,0)
  }
}
finaltype=finaltype[-1]
if(finaltype[1]==1&&finaltype[2]==0){
  type="I"
}else if(finaltype[1]==0&&finaltype[2]==1){
  type="E"
}else{
  type=0
}

if(finaltype[3]==1&&finaltype[4]==0){
  type=paste0(type,"N")
}else if(finaltype[3]==0&&finaltype[4]==1){
  type=paste0(type,"S")
}else{
  type=paste0(type,1)
}

if(finaltype[5]==1&&finaltype[6]==0){
  type=paste0(type,"T")
}else if(finaltype[5]==0&&finaltype[6]==1){
  type=paste0(type,"F")
}else{
  type=paste0(type,2)
}

if(finaltype[7]==1&&finaltype[8]==0){
  type=paste0(type,"J")
}else if(finaltype[7]==0&&finaltype[8]==1){
  type=paste0(type,"P")
}else{
  type=paste0(type,3)
}

if(finaltype[1]==finaltype[2]){
  type1=gsub(0,"I",type)
  type2=gsub(0,"E",type)
}else if(finaltype[3]==finaltype[4]){
  type1=gsub(1,"N",type)
  type2=gsub(1,"S",type)
}else if(finaltype[5]==finaltype[6]){
  type1=gsub(2,"T",type)
  type2=gsub(2,"F",type)
}else if(finaltype[7]==finaltype[8]){
  type1=gsub(3,"J",type)
  type2=gsub(3,"P",type)
}else{
  type1=7
  type2=7
}

if(type1!=7 && type2!=7){
  a=rbind(type1,type2)
}else{
  a=type
}
write(a,"/home/opendata2/R_needuse_data/output/a1.txt")
#write.csv(a,"/home/opendata2/R_needuse_data/output/a1.csv",row.names=F)

#sessionInfo()
