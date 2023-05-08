/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;

import ca.weblite.codename1.json.JSONObject;
import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.mycomany.entities.Fiche;
import com.mycomany.entities.Ordonnance;
import gui.SessionManager;
import utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author asus
 */
public class ServiceFiche {
    public boolean resultOK;
    public Fiche fiches;
    public Object token;
    public static ServiceFiche instance = null;
    private ConnectionRequest req;
    
    public ServiceFiche() {
        req = new ConnectionRequest();
    }
    public static ServiceFiche getInstance(){
        if (instance == null) {
            instance = new ServiceFiche();
        }
        return instance;
    }
    public Object getToken()
    {
        try {
            String url = Statics.BASE_URL + "/api/login_check";
            JSONObject json = new JSONObject();
            json.put("username", "benalinassim412@gmail.com");
            json.put("password", "nassim123");
            req.setUrl(url);
            req.setPost(true);
            req.setHttpMethod("POST");
            req.setRequestBody(json.toString());

            // Set the content type header to indicate that the request body is JSON
            req.addRequestHeader("Content-Type", "application/json");
           // req.addRequestHeader("Authorization", "Bearer " + token);
            req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    String res = new String(req.getResponseData());
                    JSONParser j = new JSONParser();
                    Map<String, Object> accessToken
                        = j.parseJSON(new CharArrayReader(res.toCharArray()));
                    
                    token = accessToken.get("token");
                    req.removeResponseListener(this);
                }  catch (IOException ex) {
                    System.out.println(ex.getMessage());
                }
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        }catch(Exception err) {
        System.err.println(err);
        }  
        return token;
    }
    
    public Fiche parseFiche(String jsonText) {
            Fiche f = new Fiche();
        try {
           
            JSONParser j = new JSONParser();
           Map<String, Object> ficheData
                    = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
          
            f.setId((int)Float.parseFloat(ficheData.get("id").toString()));
            f.setTel((int)Float.parseFloat(ficheData.get("tel").toString()));
            f.setEtatClinique(ficheData.get("etatClinique").toString());
            f.setGenre(ficheData.get("genre").toString());
            f.setTypeAssurance(ficheData.get("typeAssurance").toString());
            /*String DateConverter =  obj.get("date").toString().substring(obj.get("date").toString().indexOf("timestamp") +10 , obj.get("date").toString().lastIndexOf("}"));
            Date currentTime = new Date(Double.valueOf(DateConverter).longValue() * 1000);
            SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd");
            String dateString = formatter.format(currentTime);
            o.setDate(dateString);
            */

        } catch (IOException ex) {
            System.out.println(ex.getMessage());
        }
        return f;
    }
    public Fiche getAllFiche(int id) {
        /*token = ServiceFiche.getInstance().getToken().toString();
        req.addRequestHeader("Authorization", "Bearer " + token);*/
        String url = Statics.BASE_URL + "/api/ficheMobile/"+id+
                "?username=" + SessionManager.getEmail();
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                fiches = parseFiche(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return fiches;
    }
    public boolean modifierFiche(Fiche o,int id) {
        try {
            System.out.println(o.getTel());
       /* token = ServiceOrdonnance.getInstance().getToken().toString();
        req.addRequestHeader("Authorization", "Bearer " + token);*/
        int tel =o.getTel();
        String etat =o.getEtatClinique();
        String genre =o.getGenre();
        String type =o.getTypeAssurance();
        String url = Statics.BASE_URL + "/api/ficheMobile/" + id + "/edit" + "?tel=" + tel + "&etat_clinique=" + etat + "&genre=" + genre + "&type_assurance=" + type;
        JSONObject json = new JSONObject();
        json.put("tel", tel);
        json.put("etat_clinique", etat);
        json.put("genre", genre);
        json.put("type_assurance", type);
        req.setUrl(url);
        req.setHttpMethod("PUT");
        req.setRequestBody(json.toString());
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200 ;  // Code response Http 200 ok
                req.removeResponseListener(this);
            }
        });
        
        NetworkManager.getInstance().addToQueueAndWait(req);//execution ta3 request sinon yet3ada chy dima nal9awha
        }catch(Exception err) {
            System.err.println(err);
        }
        return resultOK;

        }
}
