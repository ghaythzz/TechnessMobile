/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.events.ActionListener;
import entity.Consultation;
import utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;


public class ServiceConsultation {
    
   public static ServiceConsultation instance = null ;
   
   private ConnectionRequest req ;
   
   public static ServiceConsultation getInstance(){
       
      if(instance == null) 
          instance = new ServiceConsultation();
       return instance;
   }
   
    public  ServiceConsultation() {
        req = new ConnectionRequest () ;
        
    }
    
    
    
    //ajout
    public void ajouterConsultation(Consultation consultation) {
        
        String url =  Statics.BASE_URL+"/create?start=" + consultation.getStart() + "&comment="+ consultation.getCommentaire()+ "&end="+ consultation.getEnd() ;
        req.setUrl(url);
        req.addResponseListener((e)-> {
        String str = new String(req.getResponseData());
        System.out.println("data==" + str) ;
        
        } );

        NetworkManager.getInstance().addToQueueAndWait(req);
        
    }
    
    
    public ArrayList<Consultation> affichageConsultation() {
    ArrayList<Consultation> result = new ArrayList<>();
    String url;
       url = Statics.BASE_URL+"/get";
    
    ConnectionRequest req = new ConnectionRequest();
    req.setUrl(url);
    
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            JSONParser jsonp = new JSONParser();
            try {
                Map<String, Object> mapConsultations = jsonp.parseJSON(new CharArrayReader(new String(req.getResponseData()).toCharArray()));
                List<Map<String, Object>> listOfMaps = (List<Map<String, Object>>) mapConsultations.get("root");
                
                for(Map<String, Object> obj : listOfMaps){
                    Consultation con = new Consultation();
                    float id = Float.parseFloat(obj.get("id").toString());
                   String comment = obj.get("comment").toString();
                    String start = obj.get("start").toString();
                    String end = obj.get("end").toString();
                    
                    con.setId((int) id);
                    con.setCommentaire(comment);
                    con.setStart(start);
                    con.setEnd("e");
                     System.out.println(con.getCommentaire());
                    result.add(con);
                } 
            } catch(Exception ex) {
                ex.printStackTrace();
            }
        }
    });
    
    NetworkManager.getInstance().addToQueueAndWait(req);
    return result;
}

    public void deleteConsultation(int id) {
    String url = Statics.BASE_URL + "/delete/" + id;
    req.setUrl(url);
    req.setHttpMethod("DELETE");

    req.addResponseListener((e) -> {
        String str = new String(req.getResponseData());
        System.out.println("data==" + str);
    });

    NetworkManager.getInstance().addToQueueAndWait(req);
}

    
}
