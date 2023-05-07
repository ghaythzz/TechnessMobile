/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkManager;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Dialog;
import com.codename1.ui.TextField;
import com.codename1.ui.util.Resources;
import gui.ProfileForm;
import gui.SessionManager;

//import com.mycompany.gui.SessionManager;
import java.util.Map;

/**
 *
 * @author Lenovo
 */
public class ServiceUtilisateur {

    //singleton 
    public static ServiceUtilisateur instance = null;

    public static boolean resultOk = true;
    String json;

    //initilisation connection request 
    private ConnectionRequest req;

    public static ServiceUtilisateur getInstance() {
        if (instance == null) {
            instance = new ServiceUtilisateur();
        }
        return instance;
    }

    public ServiceUtilisateur() {
        req = new ConnectionRequest();

    }

    //Signup
    public void signup(TextField nom, TextField prenom, TextField password, TextField email, Resources res) {

        String url = "http://localhost:8000/registerApi?nom=" + nom.getText() + "&prenom=" + prenom.getText()
                + "&email=" + email.getText() + "&password=" + password.getText();

        req.setUrl(url);
        //Control saisi
        if (nom.getText().equals(" ") && password.getText().equals(" ") && email.getText().equals(" ") && prenom.getText().equals(" ")) {
            Dialog.show("Erreur", "Veuillez remplir les champs", "OK", null);
        }

        //hethi wa9t tsir execution ta3 url 
        req.addResponseListener((e) -> {

            //njib data ly7atithom fi form 
            byte[] data = (byte[]) e.getMetaData();//lazm awl 7aja n7athrhom ke meta data ya3ni na5o id ta3 kol textField 
            String responseData = new String(data);//ba3dika na5o content 

            System.out.println("data ===>" + responseData);
        }
        );

        //ba3d execution ta3 requete ely heya url nestanaw response ta3 server.
        NetworkManager.getInstance().addToQueueAndWait(req);

    }

//    SignIn
    public void signin(TextField email, TextField password, Resources res) {

        String url = "http://localhost:8000/loginApi?email=" + email.getText().toString() + "&password=" + password.getText().toString();
        req = new ConnectionRequest(url, false);
        req.setUrl(url);

        req.addResponseListener((e) -> {

            JSONParser j = new JSONParser();
            String json = new String(req.getResponseData()) + "";
            try {
                if (json.equals("failed")) 
                {
                    Dialog.show("Echec d'authentification", "Username ou mot de passe éronné", "OK", null);
                }
                else 
                {
                    System.out.println("data ==" + json);
                    Map<String, Object> user = j.parseJSON(new CharArrayReader(json.toCharArray()));

                    //Session 
                    SessionManager.setUserName(user.get("nom").toString());
                    SessionManager.setprenom(user.get("prenom").toString());
                    SessionManager.setEmail(user.get("email").toString());
                  //  SessionManager.setAdresse(user.get("adresse").toString());
                  //  SessionManager.setNumero(user.get("numero").toString());

                    System.out.println("current user :" + SessionManager.getEmail() + "," + SessionManager.getPassowrd());

                    if (user.size() > 0) // l9a user
                    {
                        new ProfileForm().show();
                    }
                    System.out.println("welcome to your profile");
                }
            } 
            catch (Exception ex)
            {
                ex.printStackTrace();
            }

        });

        //ba3d execution ta3 requete ely heya url nestanaw response ta3 server.
        NetworkManager.getInstance().addToQueueAndWait(req);
    }

    //heki 5dmtha taw nhabtha ala description
    public String getPasswordByEmail(String email, Resources rs) {

        String url = "http://localhost:8000/getPasswordByEmail?email=" + email;
        req = new ConnectionRequest(url, false); //false ya3ni url mazlt matba3thtich lel server
        req.setUrl(url);

        req.addResponseListener((e) -> {

            JSONParser j = new JSONParser();

            json = new String(req.getResponseData()) + "";

            try {

                System.out.println("data ==" + json);

                Map<String, Object> password = j.parseJSON(new CharArrayReader(json.toCharArray()));

            } catch (Exception ex) {
                ex.printStackTrace();
            }

        });

        //ba3d execution ta3 requete ely heya url nestanaw response ta3 server.
        NetworkManager.getInstance().addToQueueAndWait(req);
        return json;
    }

}
