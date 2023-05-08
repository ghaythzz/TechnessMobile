/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;

import ca.weblite.codename1.json.JSONObject;
import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.Data;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.events.ActionListener;
import com.mycomany.entities.Ordonnance;
import utils.Statics;
import com.codename1.io.rest.RequestBuilder;
import com.codename1.l10n.ParseException;
import com.mycomany.entities.Reservation;
import com.mycomany.entities.Utilisateur;
import gui.SessionManager;

import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.util.ArrayList;
import java.util.List;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;
/**
 *
 * @author asus
 */
public class ServiceOrdonnance {
    public boolean resultOK;
    public ArrayList<Ordonnance> ordonnances;
    public ArrayList<Reservation> reservations;
    public ArrayList<Utilisateur> users;
    public Object token;
    private String email="";
    String em;
    public static ServiceOrdonnance instance = null;
    private ConnectionRequest req;
    
    public ServiceOrdonnance() {
        req = new ConnectionRequest();
    }
    
    public Object getToken()
    {
        try {
            String url = Statics.BASE_URL + "/api/login_check";
            JSONObject json = new JSONObject();
            json.put("username", SessionManager.getEmail());
            json.put("password", SessionManager.getPassowrd());
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

    public static ServiceOrdonnance getInstance() {
        if (instance == null) {
            instance = new ServiceOrdonnance();
        }
        return instance;
    }
    public ArrayList<Ordonnance> parseOrdonnance(String jsonText) {
        try {
            ordonnances = new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String, Object> ordonnancesListJson
                    = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));

            List<Map<String, Object>> list = (List<Map<String, Object>>) ordonnancesListJson.get("root");
            for (Map<String, Object> obj : list) {
                Ordonnance o = new Ordonnance();
                float id = Float.parseFloat(obj.get("id").toString());
                String nomM = obj.get("nomMedecin").toString();
                String nomP = obj.get("nomPatient").toString();
                Map<String, Object> users = (Map<String, Object>) obj.get("doctor");
                float userId = Float.parseFloat(users.get("id").toString());
                Map<String, Object> patient = (Map<String, Object>) obj.get("patient");
                float patientId = Float.parseFloat(patient.get("id").toString());
                String date = obj.get("date").toString();
                String commentaire = obj.get("commentaire").toString();
                o.setId((int) id);
                o.setNomMedecin(nomM);
                o.setNomPatient(nomP);
                //o.setDoctor_id((int)userId);
                o.setPatient_id((int)patientId);
                o.setDate(date);
                o.setCommentaire(commentaire);
                
                ordonnances.add(o);
            }

        } catch (IOException ex) {
            System.out.println(ex.getMessage());
        }
        return ordonnances;
    }
    public ArrayList<Ordonnance> getAllOrdonnance() {
    try {
        /*token = ServiceOrdonnance.getInstance().getToken().toString();
        req.addRequestHeader("Authorization", "Bearer " + token);*/
        
        // Append the parameters to the URL
        String url = Statics.BASE_URL + "/api/ordonnanceMobile/listePatients" +
                "?username=" + SessionManager.getEmail() +
                "&password=" + SessionManager.getPassowrd();
        
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                // Handle the response data
                String responseData = new String(req.getResponseData());
                // Parse the response data and store it in the ordonnances variable
                ordonnances = parseOrdonnance(responseData);
                
                // Handle other logic or actions based on the response
                
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
    } catch (Exception err) {
        System.err.println(err);
    }
    return ordonnances;
}
    /*public ArrayList<Ordonnance> getAllOrdonnance() {*/
        /*token = ServiceOrdonnance.getInstance().getToken().toString();
        req.addRequestHeader("Authorization", "Bearer " + token);*/
        /*String url = Statics.BASE_URL + "/api/ordonnanceMobile/listePatient";
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                ordonnances = parseOrdonnance(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return ordonnances;
    }*/
    public boolean deleteOrdonnance(int id ) {
        String url = Statics.BASE_URL +"/api/ordonnanceMobile/delete/"+id;
        
        req.setUrl(url);
        req.setHttpMethod("DELETE");
        
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                    
                    req.removeResponseCodeListener(this);
            }
        });
        
        NetworkManager.getInstance().addToQueueAndWait(req);
        return  resultOK;
    }
    
    public boolean addOrdonnance(Ordonnance t, int id) {
    try {
        String commentaire = t.getCommentaire();
        String url = Statics.BASE_URL + "/api/ordonnanceMobile/" + id + "/new" +
                "?username=" + SessionManager.getEmail() +
                "&commentaire=" + commentaire;

        ConnectionRequest req = new ConnectionRequest();
        req.setUrl(url);
        req.setPost(true);

        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; // Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });

        NetworkManager.getInstance().addToQueueAndWait(req);
    } catch (Exception err) {
        // Handle the exception appropriately, e.g., throw an exception or return an error code
        System.err.println(err);
    }
    
    return resultOK;
}
    public boolean modifierOrdonnance(Ordonnance o,int id) {
        try {
            
     
        String commentaire =o.getCommentaire();
            System.out.println(commentaire);
        String url = Statics.BASE_URL +"/api/ordonnanceMobile/"+id+"/edit"+
                "?commentaire=" + commentaire;
        req.setUrl(url);
        req.setHttpMethod("PUT");
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
    public ArrayList<Utilisateur> parsePatient(String jsonText) {
        try {
            users = new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String, Object> patientListJson
                    = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));

            List<Map<String, Object>> list = (List<Map<String, Object>>) patientListJson.get("root");
            for (Map<String, Object> obj : list) {
                Utilisateur u = new Utilisateur();
                float id = Float.parseFloat(obj.get("id").toString());
                String nomP = obj.get("nom").toString();
             
                u.setId((int) id);      
                u.setNom(nomP);
                users.add(u);
            }

        } catch (IOException ex) {
            System.out.println(ex.getMessage());
        }
        return users;
    }
    public ArrayList<Utilisateur> getAllPatient() {
        
        String url = Statics.BASE_URL + "/api/patientsMobile" +
                "?username=" + SessionManager.getEmail();
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                users = parsePatient(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return users;
    }
    public String parseUserEmail(String jsonText) {
    String email = null;
    try {
        JSONParser j = new JSONParser();
        Map<String, Object> patientJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));

        if (patientJson.containsKey("email") && patientJson.get("email") != null) {
            String nomP = patientJson.get("email").toString();
            email = nomP;
            Utilisateur u = new Utilisateur();
            u.setEmail(nomP);
        }
    } catch (IOException ex) {
        System.out.println(ex.getMessage());
    }
    return email;
}
    public String getPatientEmail(int id) {
        
        /*token = ServiceFiche.getInstance().getToken().toString();
        req.addRequestHeader("Authorization", "Bearer " + token);*/
        String url = Statics.BASE_URL + "/api/ordonnanceMobile/user/"+id;
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                em = parseUserEmail(new String(req.getResponseData()));
                System.out.println(em);
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return em;
    }
    
    public ArrayList<Reservation> parseReservation(String jsonText) {
    try {
        reservations = new ArrayList<>();
        JSONParser j = new JSONParser();
        Map<String, Object> ordonnancesListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));

        List<Map<String, Object>> list = (List<Map<String, Object>>) ordonnancesListJson.get("root");
        for (Map<String, Object> obj : list) {
            Reservation o = new Reservation();
            float id = Float.parseFloat(obj.get("id").toString());
            Map<String, Object> users = (Map<String, Object>) obj.get("users");
            float userId = Float.parseFloat(users.get("id").toString());
            Map<String, Object> patient = (Map<String, Object>) obj.get("patient");
            float patientId = Float.parseFloat(patient.get("id").toString());
            String dateStr = obj.get("start").toString();
            SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
            Date date = dateFormat.parse(dateStr);
            o.setId((int) id);
            o.setUsers_id((int) userId);
            o.setPatient_id((int) patientId);
            o.setStart(date);
            reservations.add(o);
        }
    } catch (IOException | ParseException ex) {
        System.out.println(ex.getMessage());
    }
    return reservations;
}

    public ArrayList<Reservation> getAllReservation() throws ParseException{
    try {
        /*token = ServiceOrdonnance.getInstance().getToken().toString();
        req.addRequestHeader("Authorization", "Bearer " + token);*/
        String url = Statics.BASE_URL + "/api/reservationMobile/"+
                "?username=" + SessionManager.getEmail();
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                reservations = parseReservation(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
    }catch (Exception err) {
        System.err.println(err);
    }
    return reservations;
}
}
