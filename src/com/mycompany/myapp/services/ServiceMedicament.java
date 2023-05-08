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
import com.codename1.ui.events.ActionListener;
import com.mycomany.entities.Medicament;
import com.mycomany.entities.Ordonnance;
import com.mycomany.entities.Reservation;
import com.mycomany.entities.Utilisateur;
import static com.mycompany.myapp.services.ServiceOrdonnance.instance;
import gui.SessionManager;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import utils.Statics;

/**
 *
 * @author nassi
 */
public class ServiceMedicament {
    public boolean resultOK;
    public ArrayList<Medicament> medicaments;
   
    String em;
    public static ServiceMedicament instance = null;
    private ConnectionRequest req;
    
    public ServiceMedicament() {
        req = new ConnectionRequest();
    }
    
    public static ServiceMedicament getInstance() {
        if (instance == null) {
            instance = new ServiceMedicament();
        }
        return instance;
    }
    public ArrayList<Medicament> parseOrdonnance(String jsonText) {
        try {
            medicaments = new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String, Object> ordonnancesListJson
                    = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));

            List<Map<String, Object>> list = (List<Map<String, Object>>) ordonnancesListJson.get("root");
            for (Map<String, Object> obj : list) {
                Medicament o = new Medicament();
                float id = Float.parseFloat(obj.get("id").toString());
                String nom = obj.get("Nom").toString();
                String type = obj.get("Type").toString();
                float nb_dose = Float.parseFloat(obj.get("Nb_dose").toString());
                float prix = Float.parseFloat(obj.get("Prix").toString());
                float stock =Float.parseFloat( obj.get("Stock").toString());
                o.setId((int) id);
                o.setNom(nom);
                o.setType(type);
                o.setNb_dose((int) nb_dose);
                o.setPrix((int) prix);
                o.setStock((int) stock);
                medicaments.add(o);
            }

        } catch (IOException ex) {
            System.out.println(ex.getMessage());
        }
        return medicaments;
    }
    public ArrayList<Medicament> getAllMedicament() {
    try {
        /*token = ServiceOrdonnance.getInstance().getToken().toString();
        req.addRequestHeader("Authorization", "Bearer " + token);*/
        
        // Append the parameters to the URL
        String url = Statics.BASE_URL + "/api/shop";
        
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                // Handle the response data
                String responseData = new String(req.getResponseData());
                // Parse the response data and store it in the ordonnances variable
                medicaments= parseOrdonnance(responseData);
                
                // Handle other logic or actions based on the response
                
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
    } catch (Exception err) {
        System.err.println(err);
    }
    return medicaments;
}
}
