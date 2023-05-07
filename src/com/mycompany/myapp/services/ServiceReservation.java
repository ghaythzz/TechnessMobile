/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;



import java.io.IOException;
import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.events.ActionListener;
import entity.Reservation;
import java.util.Date;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import utils.Statics;

/**
 *
 * @author selmi
 */
public class ServiceReservation {
  
    
       public static ServiceReservation instance = null ;
   
   private ConnectionRequest req ;
   
   public static ServiceReservation getInstance(){
       
      if(instance == null) 
          instance = new ServiceReservation();
       return instance;
   }
    
   
       public  ServiceReservation() {
        req = new ConnectionRequest () ;
        
    }
   
   
          public void ajouterReservation(Reservation consultation) {
        
        String url =  Statics.BASE_URL+"/createres?start=" + consultation.getstart() + "&comment="+ consultation.getComment()+ "&end="+ consultation.getend() ;
        req.setUrl(url);
        req.addResponseListener((e)-> {
        String str = new String(req.getResponseData());
        System.out.println("data==" + str) ;
        
        } );

        NetworkManager.getInstance().addToQueueAndWait(req);
        
    }
       
       
        public ArrayList<Reservation> affichageReservation() {
    ArrayList<Reservation> result = new ArrayList<>();
    String url;
       url = Statics.BASE_URL+"/getres";
    
    ConnectionRequest req = new ConnectionRequest();
    req.setUrl(url);
    
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            JSONParser jsonp = new JSONParser();
            try {
                Map<String, Object> mapReservations = jsonp.parseJSON(new CharArrayReader(new String(req.getResponseData()).toCharArray()));
                    List<Map<String, Object>> listOfMaps = (List<Map<String, Object>>) mapReservations.get("root");
                
                    for(Map<String, Object> obj : listOfMaps){
                   Reservation con = new Reservation();
                     
                    float id = Float.parseFloat(obj.get("id").toString());
                   
                    SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
                   Date startDate =  dateFormat.parse(obj.get("start").toString());
                  Date endDate =  dateFormat.parse(obj.get("end").toString());
                   String comment = obj.get("Comment").toString();
                  
                    
                    con.setId((int) id);
                 con.setstart(startDate);
                 con.setend(endDate);
                  con.setComment(comment);
                 
                      con.setComment(comment);
                   result.add(con);
                 

                   // System.out.println(result);
                } 
            } catch(Exception ex) {
                ex.printStackTrace();
            }
        }
    });    
    NetworkManager.getInstance().addToQueueAndWait(req);
    return result;
}
 
        
           public void deleteReservation(int id) {
    String url = Statics.BASE_URL + "/deleteres/" + id;
    req.setUrl(url);
    req.setHttpMethod("DELETE");

    req.addResponseListener((e) -> {
        String str = new String(req.getResponseData());
        System.out.println("data==" + str);
    });

    NetworkManager.getInstance().addToQueueAndWait(req);
}
        
}
