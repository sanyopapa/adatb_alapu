import tkinter as tk
from tkinter import messagebox as MessageBox
import mysql.connector as mysql
from datetime import datetime, timedelta
import bcrypt
from tkcalendar import DateEntry
from tkinter import messagebox

def mindent_torol():
    reg_email_label.place_forget()
    reg_nev_label.place_forget()
    reg_password_label.place_forget()
    reg_password_label1.place_forget()
    reg_email.place_forget()
    reg_nev.place_forget()
    reg_password.place_forget()
    reg_password1.place_forget()
    register_button.place_forget()
    legalabb_10_musor_button.place_forget()
    login_email_label.place_forget()
    login_password_label.place_forget()
    login_email.place_forget()
    login_password.place_forget()
    login_button.place_forget()
    csatorna_label.place_forget()
    csatornak_listbox.place_forget()
    csatorna_kereses_nev.place_forget()
    csatorna_kereses_button.place_forget()
    csatorna_leiras_textbox.place_forget()
    csatornak_listazasa_button.place_forget()
    musor_label.place_forget()
    musorok_listbox.place_forget()
    musorok_listazasa_button.place_forget()
    musor_szereplo_kereses_szoveg.place_forget()
    musor_szereplok_kereses_button.place_forget()
    szereplo_adatok_listbox.place_forget()
    csatorna_kategoria.place_forget()
    csatorna_nev_label.place_forget()
    csatorna_kategoria_label.place_forget()
    csatorna_leiras_label.place_forget()
    epizod_kereses.place_forget()
    epizod_kereses_label.place_forget()
    epizod_kereses_textbox.place_forget()
    epizod_kereses_button.place_forget()
    musor_leiras.place_forget()
    musor_leiras_szoveg.place_forget()
    musor_leiras_textbox.place_forget()
    admin_email_label.place_forget()
    admin_nev_label.place_forget()
    admin_nev_text.place_forget()
    admin_email_text.place_forget()
    admin_profilt_torol_button.place_forget()
    admin_profilt_valtoztat_button.place_forget()
    admin_jelszo_label.place_forget()
    admin_jelszo_text.place_forget()
    admin_kijelentkezes_button.place_forget()
    csatornat_frissit_button.place_forget()
    csatornat_torol_button.place_forget()
    csatornat_hozzaad_button.place_forget()
    musor_mikor_label.place_forget()
    musor_hol_label.place_forget()
    musor_mikor.place_forget()
    musor_hol.place_forget()
    musort_hozzaad_button.place_forget()
    musort_torol_button.place_forget()
    musort_frissit_button.place_forget()
    szereplo_torlese_button.place_forget()
    szereplo_hozzaadasa_button.place_forget()
    szereplo_frissitese_button.place_forget()
    legfiatalabb_szereplok_nemzetisegenkent_button.place_forget()
    epizod_frissitese_button.place_forget()
    szereplo_neve_label.place_forget()
    szereplo_neve_entry.place_forget()
    szuletesi_datum_label.place_forget()
    szuletesi_datum_entry.place_forget()
    nemzetiseg_label.place_forget()
    nemzetiseg_entry.place_forget()
    foglalkozas_label.place_forget()
    foglalkozas_entry.place_forget()
    musor_label.place_forget()
    musor_entry.place_forget()
    szereplo_kereses_button.place_forget()
def register():
    email = reg_email.get()
    nev = reg_nev.get()

    if email == "" or nev == "":
        MessageBox.showinfo("Info", "Az összes mező kitöltése kötelező")

    if reg_password.get() == "" or reg_password1.get() == "":
        MessageBox.showinfo("Info", "Mindkét jelszó mező kitöltése kötelező")
        return

    if reg_password.get() != reg_password1.get():
        MessageBox.showinfo("Info", "A jelszavak nem egyeznek")
        return

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()
    cursor.execute('SELECT * FROM admin WHERE Email = %s', (email,))
    existing_user = cursor.fetchall()
    con.close()

    if existing_user:
        MessageBox.showinfo('Info', 'Sikertelen regisztráció. Az e-mail cím már foglalt.')
    else:
        salt = bcrypt.gensalt()
        password = bcrypt.hashpw(reg_password.get().encode('utf-8'), salt)

        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()
        cursor.execute('INSERT INTO admin (Email, Nev, Jelszo) VALUES (%s, %s, %s)', (email, nev, password))
        con.commit()
        con.close()

        MessageBox.showinfo('Info', 'Sikeres regisztráció')
        reg_email.delete(0, 'end')
        reg_nev.delete(0, 'end')
        reg_password.delete(0, 'end')
        reg_password1.delete(0, 'end')
def login():
    email = login_email.get()
    password = login_password.get()

    if email == "" or password == "":
        MessageBox.showinfo("Info", "Mindkét mező kitöltése kötelező")
        return

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    cursor.execute('SELECT * FROM admin WHERE Email = %s', (email,))
    rows = cursor.fetchall()

    if len(rows) > 0:
        stored_password = rows[0][2]

        if bcrypt.checkpw(password.encode('utf-8'), stored_password.encode('utf-8')):
            MessageBox.showinfo('Info', 'Sikeres bejelentkezés')
            global admin_email
            admin_email = email
            update_last_login(con, email)
            show_reglog_button.place_forget()
            show_profil_button.place(x=20, y=10)
            global bejelentkezett_e
            bejelentkezett_e = True
            mindent_torol()
            login_email.delete(0, 'end')
            login_password.delete(0, 'end')
            root.title("Admin nézet")

        else:
            MessageBox.showinfo('Info', 'Hibás jelszó')
    else:
        MessageBox.showinfo('Info', 'A felhasználó nem létezik')

    con.close()
def update_last_login(connection, email):
    update_query = 'UPDATE admin SET `Utolso_belepes` = %s WHERE `Email` = %s'
    current_time = datetime.now() + timedelta(hours=1)
    cursor = connection.cursor()
    cursor.execute(update_query, (current_time, email))
    connection.commit()
    cursor.close()
def show_reglog():
    mindent_torol()
    root.title("Bejelentkezés/regisztráció")
    reg_email_label.place(x=20, y=60)
    reg_nev_label.place(x=20, y=90)
    reg_password_label.place(x=20, y=120)
    reg_password_label1.place(x=20, y=150)
    reg_email.place(x=200, y=60)
    reg_nev.place(x=200, y=90)
    reg_password.place(x=200, y=120)
    reg_password1.place(x=200, y=150)
    register_button.place(x=20, y=190)
    login_email_label.place(x=20, y=250)
    login_password_label.place(x=20, y=280)
    login_email.place(x=200, y=250)
    login_password.place(x=200, y=280)
    login_button.place(x=20, y=310)
def show_csatornak():
    global bejelentkezett_e
    mindent_torol()
    root.title("Csatornák")
    csatorna_label.place(x=20, y=40)
    csatornak_listbox.place(x=20, y=60)
    csatornak_listazasa_button.place(x=20, y=180)
    csatorna_kereses_nev.place(x=200, y=60)
    csatorna_kereses_button.place(x=200, y=90)
    csatorna_leiras_textbox.place(x=200, y=130)
    csatorna_kategoria.place(x=200, y=230)
    csatorna_nev_label.place(x=320, y=60)
    csatorna_leiras_label.place(x=390, y=160)
    csatorna_kategoria_label.place(x=350, y=230)
    legalabb_10_musor_button.place(x=20, y=210)
    if bejelentkezett_e:
        csatornat_frissit_button.place(x=20, y=300)
        csatornat_torol_button.place(x=150, y=300)
        csatornat_hozzaad_button.place(x=280, y=300)
def show_epizodok():
    global bejelentkezett_e
    mindent_torol()
    root.title("Epizódok")
    epizod_kereses.place(x=20, y=60)
    epizod_kereses_label.place(x=20, y=40)
    epizod_kereses_textbox.place(x=20, y=130)
    epizod_kereses_button.place(x=20, y=90)
    if bejelentkezett_e:
        epizod_frissitese_button.place(x=20, y=230)
        szereplo_neve_label.place(x=20, y=280)
        szereplo_neve_entry.place(x=20, y=300)

        szuletesi_datum_label.place(x=20, y=330)
        szuletesi_datum_entry.place(x=20, y=350)

        nemzetiseg_label.place(x=20, y=380)
        nemzetiseg_entry.place(x=20, y=400)

        foglalkozas_label.place(x=20, y=430)
        foglalkozas_entry.place(x=20, y=450)

        musor_label.place(x=20, y=480)
        musor_entry.place(x=20, y=500)

        szereplo_kereses_button.place(x=20, y=540)
        szereplo_torlese_button.place(x=200, y=320)
        szereplo_hozzaadasa_button.place(x=200, y=290)
        szereplo_frissitese_button.place(x=200, y=260)
def show_musor():
    global bejelentkezett_e
    mindent_torol()
    root.title("Műsorok")
    musor_label.place(x=20, y=40)
    musorok_listbox.place(x=20, y=60)
    musorok_listazasa_button.place(x=20, y=150)
    musor_szereplo_kereses_szoveg.place(x=200, y=60)
    musor_szereplok_kereses_button.place(x=200, y=90)
    szereplo_adatok_listbox.place(x=200, y=130)
    musor_leiras_szoveg.place(x=20, y=220)
    musor_leiras.place(x=20, y=250)
    musor_leiras_textbox.place(x=20, y=280)
    legfiatalabb_szereplok_nemzetisegenkent_button.place(x=200, y=220)
    musor_mikor_label.place(x=20, y=380)
    musor_mikor.place(x=20, y=410)
    musor_hol_label.place(x=150, y=380)
    musor_hol.place(x=150, y=410)
    if bejelentkezett_e:
        musort_hozzaad_button.place(x=20, y=440)
        musort_torol_button.place(x=150, y=440)
        musort_frissit_button.place(x=280, y=440)
def csatornak_listazasa():
    csatornak_list = lekerdez_csatornak()
    csatornak_listbox.delete(0, tk.END)
    for csatorna in csatornak_list:
        csatornak_listbox.insert(tk.END, f"{csatorna[0]} - {csatorna[1]}")
def lekerdez_csatornak():
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    cursor.execute('SELECT Nev, Kategoria FROM csatorna')
    csatornak_list = cursor.fetchall()

    con.close()

    return csatornak_list
def csatorna_leiras():
    csatorna_nev = csatorna_kereses_nev.get()

    if csatorna_nev == "":
        MessageBox.showinfo("Info", "Csatorna név megadása kötelező!")
        return

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT Leiras, Kategoria FROM csatorna WHERE Nev = %s', (csatorna_nev,))
        csatorna_data = cursor.fetchone()

        if csatorna_data:
            csatorna_leiras_textbox.delete(1.0, tk.END)  # Törli a meglévő szöveget
            csatorna_leiras_textbox.insert(tk.END, csatorna_data[0])  # Beilleszti a leírást
            csatorna_kategoria.delete(0, tk.END)  # Törli a meglévő szöveget
            csatorna_kategoria.insert(0, csatorna_data[1])  # Beilleszti a kategóriát
        else:
            MessageBox.showinfo("Info", "Nincs ilyen nevű csatorna!")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def musorok_listazasa():
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT Cim, Mikor, Hol FROM musor')
        musorok_list = cursor.fetchall()

        musorok_listbox.delete(0, tk.END)

        for musor in musorok_list:
            musorok_listbox.insert(tk.END, musor[0] + ", " + str(musor[1]) + ", " + musor[2])

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def epizod_keres():
    epizod_kereses_textbox.delete("1.0", tk.END)

    keresett_musor = epizod_kereses.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT Cim FROM musor WHERE Cim = %s', (keresett_musor,))
        musor_exists = cursor.fetchone()

        if musor_exists:
            cursor.execute('SELECT * FROM epizodok WHERE Cim = %s', (keresett_musor,))
            rows = cursor.fetchall()

            for row in rows:
                epizod_kereses_textbox.insert(tk.END, f"{row[1]}\n")
        else:
            epizod_kereses_textbox.insert(tk.END, "Nincs ilyen műsor!")

    except Exception as e:
        MessageBox.showerror("Hiba", f"Hiba történt: {str(e)}")
    finally:
        con.close()
def musor_leiras():
    keresett_musor_cim = musor_leiras_szoveg.get().lower()
    keresett_musor_hol = musor_hol.get().lower()
    keresett_musor_mikor = musor_mikor.get()
    if not keresett_musor_hol or not keresett_musor_mikor or not keresett_musor_cim:
        MessageBox.showinfo("Info", "Kötelező minden keresőmező kitöltése (időpont, csatorna, név)!")
        return
    keresett_musor_mikor = timedelta(*map(int, keresett_musor_mikor.split(":")))

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute(
            'SELECT Ismerteto, Hol, Mikor FROM musor WHERE LOWER(Cim) = %s AND LOWER(Hol) = %s AND Mikor = %s',
            (keresett_musor_cim, keresett_musor_hol, keresett_musor_mikor))
        leiras_hol_mikor = cursor.fetchone()

        if leiras_hol_mikor:
            musor_leiras_textbox.delete(1.0, tk.END)
            musor_leiras_textbox.insert(tk.END, leiras_hol_mikor[0])

            musor_hol.delete(0, tk.END)
            musor_hol.insert(0, leiras_hol_mikor[1])

            musor_mikor.delete(0, tk.END)
            musor_mikor.insert(0, leiras_hol_mikor[2])
        else:
            musor_leiras_textbox.delete(1.0, tk.END)
            musor_hol.delete(0, tk.END)
            musor_mikor.delete(0, tk.END)
            MessageBox.showinfo("Info", "Nincs ilyen műsor az adatbázisban!")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def szereplok_listazasa():
    # Listázza ki ABC-sorrendben a felhasználó által kiválasztott műsor szereplőinek összes adatát!
    # Ha nem írtam be semmit akkor az összes szereplő adatát
    szereplo_adatok_listbox.delete("1.0", tk.END)

    keresett_szereplo = musor_szereplo_kereses_szoveg.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        if not keresett_szereplo:
            cursor.execute('SELECT * FROM szereplok ORDER BY Nev')
        else:
            cursor.execute('SELECT Cim FROM musor WHERE Cim = %s', (keresett_szereplo,))
            musor_exists = cursor.fetchone()

            if musor_exists:
                cursor.execute('SELECT * FROM szereplok WHERE Cim = %s ORDER BY Nev', (keresett_szereplo,))
            else:
                szereplo_adatok_listbox.insert(tk.END, "Nincs ilyen műsor!")
                return

        rows = cursor.fetchall()

        for row in rows:
            szereplo_adatok_listbox.insert(tk.END, f"Név: {row[4]}, Születési dátum: {row[1]}, Foglalkozás: {row[2]}, Nemzetiség: {row[3]}, Műsor: {row[0]}\n")

    except Exception as e:
        MessageBox.showerror("Hiba", f"Hiba történt: {str(e)}")
    finally:
        con.close()
def show_profile():
    global admin_email_text, admin_nev
    root.title("Profil")

    mindent_torol()

    admin_email_text = tk.Entry(root)
    admin_email_text.insert(0, admin_email)
    admin_email_text.place(x=200, y=60)

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()
    cursor.execute('SELECT Nev FROM admin WHERE Email = %s', (admin_email,))
    admin_nev = cursor.fetchone()
    con.close()

    admin_nev_text.insert(0, admin_nev[0] if admin_nev else "")
    admin_nev_text.place(x=200, y=90)

    admin_email_label.place(x=20, y=60)
    admin_nev_label.place(x=20, y=90)
    admin_jelszo_label.place(x=20, y=120)
    admin_jelszo_text.place(x=200, y=120)
    admin_profilt_torol_button.place(x=20, y=150)
    admin_profilt_valtoztat_button.place(x=200, y=150)
    admin_kijelentkezes_button.place(x=380, y=150)
def delete_profile():
    global admin_email, bejelentkezett_e
    email = admin_email_text.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()
    try:
        cursor.execute('DELETE FROM admin WHERE Email = %s', (email,))
        con.commit()
        MessageBox.showinfo("Info", "Profil sikeresen törölve")
        mindent_torol()
        bejelentkezett_e = False
        admin_email = ""
        show_profil_button.place_forget()
        show_reglog_button.place(x=20, y=10)
    except Exception as e:
        con.rollback()
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")
    finally:
        con.close()
def update_profile():
    global admin_email, admin_nev

    new_email = admin_email_text.get()
    new_name = admin_nev_text.get()
    new_password = admin_jelszo_text.get()

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    cursor.execute('SELECT * FROM admin WHERE Email = %s', (admin_email,))
    rows = cursor.fetchall()
    stored_password = rows[0][2]

    if (
        bcrypt.checkpw(new_password.encode('utf-8'), stored_password.encode('utf-8'))
        and admin_nev == new_name
        and admin_email == new_email
    ):
        MessageBox.showinfo("Info", "A profilon nem változtattál semmit!")
        return

    try:
        if new_password:
            hashed_password = bcrypt.hashpw(new_password.encode('utf-8'), bcrypt.gensalt())
            cursor.execute(
                'UPDATE admin SET Email = %s, Nev = %s, Jelszo = %s WHERE Email = %s',
                (new_email, new_name, hashed_password, admin_email)
            )
        else:
            cursor.execute('UPDATE admin SET Email = %s, Nev = %s WHERE Email = %s', (new_email, new_name, admin_email))

        con.commit()
        admin_email = new_email
        admin_nev = new_name
        MessageBox.showinfo("Info", "Profil sikeresen frissítve")
    except Exception as e:
        con.rollback()
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")
    finally:
        con.close()
def logout():
    global admin_email, bejelentkezett_e
    bejelentkezett_e = False
    admin_email = ""
    mindent_torol()
    show_profil_button.place_forget()
    show_reglog_button.place(x=20, y=10)
    MessageBox.showinfo("Info", "Kijelentkezés megtörtént")
def csatornat_frissit():
    global admin_email
    csatorna_nev = csatorna_kereses_nev.get()
    csatorna_leiras = csatorna_leiras_textbox.get("1.0", tk.END).strip()
    csatorna_kategoria_value = csatorna_kategoria.get()

    if not csatorna_nev or not csatorna_leiras or not csatorna_kategoria_value:
        MessageBox.showinfo("Info", "Minden mező kitöltése kötelező")
        return

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT * FROM csatorna WHERE Nev = %s', (csatorna_nev,))
        existing_channel = cursor.fetchone()

        if existing_channel:
            if (
                existing_channel[2] == csatorna_leiras
                and existing_channel[1] == csatorna_kategoria_value
            ):
                MessageBox.showinfo("Info", "Nem változtattál semmit!")
            else:
                cursor.execute(
                    'UPDATE csatorna SET Leiras = %s, Kategoria = %s, Email = %s WHERE Nev = %s',
                    (csatorna_leiras, csatorna_kategoria_value, admin_email, csatorna_nev)
                )
                con.commit()
                MessageBox.showinfo("Info", "Csatorna sikeresen frissítve!")

        else:
            MessageBox.showinfo("Info", "Ilyen csatorna nem létezik!")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def csatornat_torol():
    csatorna_nev = csatorna_kereses_nev.get()

    if not csatorna_nev:
        MessageBox.showinfo("Info", "Csatorna név megadása kötelező")
        return

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT * FROM csatorna WHERE Nev = %s', (csatorna_nev,))
        existing_channel = cursor.fetchone()

        if existing_channel:
            cursor.execute('DELETE FROM csatorna WHERE Nev = %s', (csatorna_nev,))
            con.commit()
            MessageBox.showinfo("Info", "Csatorna sikeresen törölve!")
            csatorna_kereses_nev.delete(0, 'end')
            csatorna_kategoria.delete(0, 'end')
            csatorna_leiras_textbox.delete("1.0", tk.END)
        else:
            MessageBox.showinfo("Info", "Nincs ilyen nevű csatorna!")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def csatornat_hozzaad():
    global admin_email
    csatorna_nev = csatorna_kereses_nev.get()
    csatorna_kategoria_value = csatorna_kategoria.get()
    csatorna_leiras = csatorna_leiras_textbox.get("1.0", tk.END).strip()

    if not csatorna_nev or not csatorna_kategoria_value or not csatorna_leiras:
        MessageBox.showinfo("Info", "Minden mező kitöltése kötelező")
        return

    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT * FROM csatorna WHERE Nev = %s', (csatorna_nev,))
        existing_channel = cursor.fetchone()

        if existing_channel:
            MessageBox.showinfo("Info", "Ez a csatorna már létezik!")
        else:
            cursor.execute(
                'INSERT INTO csatorna (Nev, Leiras, Kategoria, Email) VALUES (%s, %s, %s, %s)',
                (csatorna_nev, csatorna_leiras, csatorna_kategoria_value, admin_email)
            )
            con.commit()
            MessageBox.showinfo("Info", "Csatorna sikeresen hozzáadva!")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def musort_hozzaad():
    global admin_email
    m_cim = musor_leiras_szoveg.get()
    m_ismerteto = musor_leiras_textbox.get("1.0", tk.END).strip()
    m_mikor_str = musor_mikor.get()
    m_hol = musor_hol.get()
    m_email = admin_email

    if not m_cim or not m_ismerteto or not m_mikor_str or not m_hol:
        MessageBox.showinfo("Info", "Minden mező kitöltése kötelező")
        return

    try:
        m_mikor = timedelta(*map(int, m_mikor_str.split(":")))

        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        cursor.execute('SELECT * FROM musor WHERE Cim = %s AND Hol = %s AND Mikor = %s', (m_cim, m_hol, m_mikor))
        existing_program = cursor.fetchone()

        if existing_program:
            MessageBox.showinfo("Info", "Ez a műsor már létezik ezen a csatornán és ebben az időpontban.")
        else:
            cursor.execute('SELECT * FROM csatorna WHERE Nev = %s', (m_hol,))
            existing_channel = cursor.fetchone()

            if existing_channel:
                cursor.execute(
                    'INSERT INTO musor (Cim, Mikor, Hol, Ismerteto, Email) VALUES (%s, %s, %s, %s, %s)',
                    (m_cim, m_mikor, m_hol, m_ismerteto, m_email)
                )
                con.commit()
                cursor.execute(
                    'INSERT INTO vetit (Cim, Nev) VALUES (%s, %s)',
                    (m_cim, m_hol)
                )
                con.commit()
                MessageBox.showinfo("Info", "A műsor sikeresen hozzáadva a csatornához!")
            else:
                MessageBox.showinfo("Info", "Ez a csatorna nem létezik, nem vetíthetsz rajta műsort.")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def musort_torol():
    m_cim = musor_leiras_szoveg.get()
    m_mikor_str = musor_mikor.get()
    m_hol = musor_hol.get()

    if not m_cim or not m_mikor_str or not m_hol:
        MessageBox.showinfo("Info", "Kötelező minden mezőt kitölteni (cím, időpont, csatorna)!")
        return

    try:
        m_mikor = timedelta(*map(int, m_mikor_str.split(":")))

        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        cursor.execute('SELECT * FROM musor WHERE Cim = %s AND Hol = %s AND Mikor = %s', (m_cim, m_hol, m_mikor))
        existing_program = cursor.fetchone()

        if existing_program:
            cursor.execute('DELETE FROM musor WHERE Cim = %s AND Hol = %s AND Mikor = %s', (m_cim, m_hol, m_mikor))
            con.commit()
            MessageBox.showinfo("Info", "A műsor sikeresen törölve!")
            musor_leiras_szoveg.delete(0, tk.END)
            musor_mikor.delete(0, tk.END)
            musor_hol.delete(0, tk.END)
            musor_leiras_textbox.delete(1.0, tk.END)
        else:
            MessageBox.showinfo("Info", "Nincs ilyen nevű műsor ezen a csatornán és ebben az időpontban.")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def musort_frissit():
    global admin_email
    m_cim = musor_leiras_szoveg.get()
    m_ismerteto = musor_leiras_textbox.get("1.0", tk.END).strip()
    m_mikor_str = musor_mikor.get()
    m_hol = musor_hol.get()
    m_email = admin_email

    if not m_cim or not m_ismerteto or not m_mikor_str or not m_hol:
        MessageBox.showinfo("Info", "Minden mező kitöltése kötelező")
        return

    con = None
    modified = False

    try:
        m_mikor = timedelta(*map(int, m_mikor_str.split(":")))

        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        cursor.execute('SELECT * FROM musor WHERE Cim = %s AND Hol = %s AND Mikor = %s', (m_cim, m_hol, m_mikor))
        existing_program = cursor.fetchone()

        if existing_program:
            if existing_program[3] != m_ismerteto:
                cursor.execute(
                    'UPDATE musor SET Ismerteto = %s, Email = %s WHERE Cim = %s AND Hol = %s AND Mikor = %s',
                    (m_ismerteto, m_email, m_cim, m_hol, m_mikor)
                )
                con.commit()
                modified = True

        else:
            MessageBox.showinfo("Info", "Nincs ilyen nevű műsor ezen a csatornán és ebben az időpontban.")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        if con:
            con.close()

    if modified:
        MessageBox.showinfo("Info", "A műsor adatai sikeresen frissítve!")
    else:
        MessageBox.showinfo("Info", "Nem változtattál semmin!")
def szereplot_torol():
    nev = szereplo_neve_entry.get()
    szuletesi_datum_str = szuletesi_datum_entry.get()
    cim = musor_entry.get()

    if not nev or not szuletesi_datum_str or not cim:
        messagebox.showinfo("Info", "Minden keresőmező kitöltése kötelező!")
        return

    try:
        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        szuletesi_datum = datetime.strptime(szuletesi_datum_str, "%Y-%m-%d").date()

        cursor.execute('SELECT * FROM szereplok WHERE Nev = %s AND Szuletesi_datum = %s AND Cim = %s', (nev, szuletesi_datum, cim))
        szereplo = cursor.fetchone()

        if szereplo:
            cursor.execute('DELETE FROM szereplok WHERE Nev = %s AND Szuletesi_datum = %s AND Cim = %s', (nev, szuletesi_datum, cim))
            con.commit()
            messagebox.showinfo("Info", "Szereplő sikeresen törölve!")

            szereplo_neve_entry.delete(0, tk.END)
            szuletesi_datum_entry.delete(0, tk.END)
            nemzetiseg_entry.delete(0, tk.END)
            foglalkozas_entry.delete(0, tk.END)
            musor_entry.delete(0, tk.END)

        else:
            messagebox.showinfo("Info", "Nincs ilyen szereplő az adatbázisban!")

    except Exception as e:
        messagebox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def szereplot_hozzaad():
    nev = szereplo_neve_entry.get()
    szuletesi_datum_str = szuletesi_datum_entry.get()
    nemzetiseg = nemzetiseg_entry.get()
    foglalkozas = foglalkozas_entry.get()
    cim = musor_entry.get()

    if not nev or not szuletesi_datum_str or not nemzetiseg or not foglalkozas or not cim:
        messagebox.showinfo("Info", "Minden adatmező kitöltése kötelező!")
        return

    try:
        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        szuletesi_datum = datetime.strptime(szuletesi_datum_str, "%Y-%m-%d").date()

        cursor.execute('SELECT * FROM szereplok WHERE Nev = %s AND Szuletesi_datum = %s AND Cim = %s', (nev, szuletesi_datum, cim))
        existing_actor = cursor.fetchone()

        if existing_actor:
            messagebox.showinfo("Info", "Ez a szereplő már létezik!")

        else:
            cursor.execute('SELECT * FROM musor WHERE Cim = %s', (cim,))
            existing_show = cursor.fetchone()

            if existing_show:
                cursor.execute(
                    'INSERT INTO szereplok (Cim, Szuletesi_datum, Nemzetiseg, Foglalkozas, Nev) VALUES (%s, %s, %s, %s, %s)',
                    (cim, szuletesi_datum, nemzetiseg, foglalkozas, nev)
                )
                con.commit()
                messagebox.showinfo("Info", "Szereplő sikeresen hozzáadva!")

            else:
                messagebox.showinfo("Info", "Nincs ilyen műsor az adatbázisban, amiben szerepelni lehet!")

    except Exception as e:
        messagebox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def szereplot_frissit():
    nev = szereplo_neve_entry.get()
    szuletesi_datum_str = szuletesi_datum_entry.get()
    cim = musor_entry.get()

    if not nev or not szuletesi_datum_str or not cim:
        messagebox.showinfo("Info", "Minden keresőmező kitöltése kötelező!")
        return

    try:
        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        szuletesi_datum = datetime.strptime(szuletesi_datum_str, "%Y-%m-%d").date()

        cursor.execute('SELECT * FROM szereplok WHERE Nev = %s AND Szuletesi_datum = %s AND Cim = %s', (nev, szuletesi_datum, cim))
        szereplo = cursor.fetchone()

        if szereplo:
            if (
                szereplo_neve_entry.get() == szereplo[4] and
                szuletesi_datum_entry.get() == szuletesi_datum_str and
                nemzetiseg_entry.get() == szereplo[2] and
                foglalkozas_entry.get() == szereplo[3] and
                musor_entry.get() == szereplo[0]
            ):
                messagebox.showinfo("Info", "Nem változtattál semmit!")
            else:
                cursor.execute(
                    'UPDATE szereplok SET Cim = %s, Szuletesi_datum = %s, Foglalkozas = %s, Nemzetiseg = %s, Nev = %s WHERE Nev = %s AND Szuletesi_datum = %s AND Cim = %s',
                    (
                        musor_entry.get(),
                        szuletesi_datum_str,
                        foglalkozas_entry.get(),
                        nemzetiseg_entry.get(),
                        szereplo_neve_entry.get(),
                        nev,
                        szuletesi_datum_str,
                        cim
                    )
                )
                con.commit()
                messagebox.showinfo("Info", "Szereplő adatai sikeresen frissítve!")

        else:
            messagebox.showinfo("Info", "Nincs ilyen szereplő az adatbázisban!")

    except Exception as e:
        messagebox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()

def szereplo_keresese():
    nev = szereplo_neve_entry.get()
    szuletesi_datum_str = szuletesi_datum_entry.get()
    cim = musor_entry.get()

    if not nev or not szuletesi_datum_str or not cim:
        messagebox.showinfo("Info", "Minden keresőmező kitöltése kötelező!")
        return

    try:
        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        szuletesi_datum = datetime.strptime(szuletesi_datum_str, "%Y-%m-%d").date()

        cursor.execute('SELECT * FROM szereplok WHERE Nev = %s AND Szuletesi_datum = %s AND Cim = %s', (nev, szuletesi_datum, cim))
        szereplo = cursor.fetchone()

        if szereplo:
            szereplo_neve_entry.delete(0, tk.END)
            szereplo_neve_entry.insert(0, szereplo[4])

            szuletesi_datum_entry.delete(0, tk.END)
            szuletesi_datum_entry.insert(0, szuletesi_datum_str)

            nemzetiseg_entry.delete(0, tk.END)
            nemzetiseg_entry.insert(0, szereplo[3])

            foglalkozas_entry.delete(0, tk.END)
            foglalkozas_entry.insert(0, szereplo[2])

            musor_entry.delete(0, tk.END)
            musor_entry.insert(0, szereplo[0])
        else:
            messagebox.showinfo("Info", "Nincs ilyen szereplő az adatbázisban!")

    except Exception as e:
        messagebox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def legfiatalabb_szereplo_nemzetisegenkent():
    con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
    cursor = con.cursor()

    try:
        cursor.execute('SELECT Nemzetiseg, MIN(Szuletesi_datum) AS LegfiatalabbSzuletesiDatum FROM szereplok GROUP BY Nemzetiseg')
        result = cursor.fetchall()
        if szereplo_adatok_listbox.get("1.0", "end-1c"):
            szereplo_adatok_listbox.delete("1.0", tk.END)
        for row in result:
            szereplo_adatok_listbox.insert(tk.END, f"Nemzetiség: {row[0]}, Születési dátum: {row[1]}\n")

    except Exception as e:
        MessageBox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()
def epizodot_frissit():
    m_nev = epizod_kereses.get()
    epizodok_str = epizod_kereses_textbox.get("1.0", tk.END).strip()

    if not m_nev:
        messagebox.showinfo("Info", "Műsor nevének megadása kötelező!")
        return

    try:
        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        cursor.execute('SELECT * FROM musor WHERE Cim = %s', (m_nev,))
        musor = cursor.fetchone()

        if musor:
            cursor.execute('SELECT Epizod FROM epizodok WHERE Cim = %s', (m_nev,))
            current_epizodok = [epizod[0] for epizod in cursor.fetchall()]

            stripped_epizodok = [epizod.strip() for epizod in epizodok_str.split("\n")]
            new_epizodok = [int(epizod) for epizod in stripped_epizodok if epizod.isdigit()]

            if set(current_epizodok) != set(new_epizodok):
                cursor.execute('DELETE FROM epizodok WHERE Cim = %s', (m_nev,))

                for epizod_sorszam in new_epizodok:
                    cursor.execute('INSERT INTO epizodok (Cim, Epizod) VALUES (%s, %s)', (m_nev, epizod_sorszam))

                con.commit()
                messagebox.showinfo("Info", "Az epizódok sikeresen frissítve!")
            else:
                messagebox.showinfo("Info", "Nem változtattál semmit az epizódokon.")

        else:
            messagebox.showinfo("Info", "Nincs ilyen nevű műsor az adatbázisban!")

    except Exception as e:
        messagebox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()

# Listázza ki táblázatosan a felhasználó által megadott napon a kereskedelmi kategóriájú
# csatornák műsorkínálatát időrendi sorrendben! (nincs megvalósítva)
# 2 pont
def legalabb_10_musor():
    # Listázza ki, hogy (a rendszerdátum szerint) ma melyik csatornán vetítenek legalább 10
    # műsort, ha ugyanazon műsor ismétlését egy napon belül nem vesszük figyelembe a
    # számításnál!
    # 2 pont
    try:
        con = mysql.connect(host=dbhost, user=dbuser, password=dbpass, database=dbname)
        cursor = con.cursor()

        today = datetime.now().date()

        cursor.execute('''
            SELECT m.Hol
            FROM musor AS m
            WHERE DATE(m.Mikor) = %s
            GROUP BY m.Hol
            HAVING COUNT(DISTINCT m.Cim) >= 10
        ''', (today,))

        csatornak = [csatorna[0] for csatorna in cursor.fetchall()]

        csatornak_listbox.delete(0, tk.END)

        for csatorna in csatornak:
            csatornak_listbox.insert(tk.END, csatorna)

    except Exception as e:
        messagebox.showerror("Error", f"Hiba történt: {str(e)}")

    finally:
        con.close()

if __name__ == '__main__':
    dbhost = 'localhost'
    dbuser = 'teszt'
    dbpass = 'teszt123'
    dbname = 'musorujsag'

    admin_email = ""
    admin_nev = ""
    bejelentkezett_e = False
    root = tk.Tk()
    root.geometry("500x600")
    root.title("Műsorújság")

    reg_email_label = tk.Label(root, text='Regisztráció - E-mail', font=('bold', 10))

    reg_nev_label = tk.Label(root, text='Regisztráció - Név', font=('bold', 10))

    reg_password_label = tk.Label(root, text='Regisztráció - Jelszó', font=('bold', 10))

    reg_password_label1 = tk.Label(root, text='            Jelszó ismét', font=('bold', 10))

    reg_email = tk.Entry()

    reg_nev = tk.Entry()

    reg_password = tk.Entry()

    reg_password1 = tk.Entry()

    register_button = tk.Button(root, text="Regisztráció", font=('italic', 10), bg="white", command=register)

    login_email_label = tk.Label(root, text='Bejelentkezés - E-mail', font=('bold', 10))

    login_password_label = tk.Label(root, text='Bejelentkezés - Jelszó', font=('bold', 10))

    login_email = tk.Entry()

    login_password = tk.Entry()

    login_button = tk.Button(root, text="Bejelentkezés", font=('italic', 10), bg="white", command=login)

    # navigációs gombok
    show_reglog_button = tk.Button(root, text="Reg/Log", font=('italic', 10), bg="white", command=show_reglog)
    show_reglog_button.place(x=20, y=10)

    show_csatornak_button = tk.Button(root, text="Csatornák", font=('italic', 10), bg="white", command=show_csatornak)
    show_csatornak_button.place(x=140, y=10)

    show_musor_button = tk.Button(root, text="Műsorok", font=('italic', 10), bg="white", command=show_musor)
    show_musor_button.place(x=260, y=10)

    show_epizodok_button = tk.Button(root, text="Epizódok", font=('italic', 10), bg="white", command=show_epizodok)
    show_epizodok_button.place(x=380, y=10)

    #csatornák
    csatorna_label = tk.Label(root, text="Csatornák")

    csatornak_listbox = tk.Listbox(root, height=5, selectmode=tk.SINGLE, width=28)

    csatornak_listazasa_button = tk.Button(root, text="Csatornák listázása", font=('italic', 10), bg="white", command=csatornak_listazasa)

    csatorna_kereses_nev = tk.Entry()

    csatorna_kereses_button = tk.Button(root, text="Csatorna adatai", font=('italic', 10), bg="white", command=csatorna_leiras)

    csatorna_leiras_textbox = tk.Text(root, wrap=tk.WORD, height=5, width=20)
    csatorna_leiras_textbox.insert(tk.END, "A keresett csatorna leírása")

    csatorna_kategoria = tk.Entry()

    csatorna_nev_label = tk.Label(root, text='- Név', font=('bold', 10))
    csatorna_leiras_label = tk.Label(root, text='- Leírás', font=('bold', 10))
    csatorna_kategoria_label = tk.Label(root, text='- Kategória', font=('bold', 10))
    legalabb_10_musor_button = tk.Button(root, text="Legalább 10 műsor ma", font=('italic', 10), bg="white", command=legalabb_10_musor)

    # Műsor ablak
    musor_label = tk.Label(root, text="Műsorok")

    musorok_listbox = tk.Listbox(root, height=5,width=28,  selectmode=tk.SINGLE)

    musorok_listazasa_button = tk.Button(root, text="Műsorok listázása", font=('italic', 10), bg="white",
                                           command=musorok_listazasa)

    musor_szereplo_kereses_szoveg = tk.Entry()

    musor_szereplok_kereses_button = tk.Button(root, text="Szereplők listázása", font=('italic', 10), bg="white",
                                        command=szereplok_listazasa)

    szereplo_adatok_listbox = tk.Text(root, wrap=tk.WORD, height=5, width=35)

    musor_leiras = tk.Button(root, text="Műsor adatai", font=('italic', 10), bg="white",
                                           command=musor_leiras)
    musor_leiras_szoveg = tk.Entry()

    musor_leiras_textbox = tk.Text(root, wrap=tk.WORD, height=5, width=20)
    musor_mikor_label = tk.Label(root, text='Mikor vetítik:', font=('bold', 10))
    musor_hol_label = tk.Label(root, text='Hol vetítik:', font=('bold', 10))
    musor_mikor = tk.Entry()
    musor_hol = tk.Entry()

    #Epizódok ablak
    epizod_kereses = tk.Entry()
    epizod_kereses_label = tk.Label(root, text='Műsor:', font=('bold', 10))
    epizod_kereses_textbox = tk.Text(root, wrap=tk.WORD, height=5, width=20)
    epizod_kereses_button = tk.Button(root, text="Keresés", font=('italic', 10), bg="white",
                                     command=epizod_keres)

    #bejelentkezett mód
    show_profil_button = tk.Button(root, text="Profil", font=('italic', 10), bg="white",
                             command=show_profile)
    admin_email_label = tk.Label(root, text='Email:', font=('bold', 10))
    admin_nev_label = tk.Label(root, text='Név:', font=('bold', 10))
    admin_email_text = tk.Entry()
    admin_nev_text = tk.Entry()
    admin_jelszo_label = tk.Label(root, text='(Új)jelszó:', font=('bold', 10))
    admin_jelszo_text = tk.Entry()
    admin_profilt_torol_button = tk.Button(root, text="Profil törlése", font=('italic', 10), bg="white",
                             command=delete_profile)
    admin_profilt_valtoztat_button = tk.Button(root, text="Profil frissítése", font=('italic', 10), bg="white",
                             command=update_profile)
    admin_kijelentkezes_button = tk.Button(root, text="Kijelentkezés", font=('italic', 10), bg="white", command=logout)

    csatornat_frissit_button = tk.Button(root, text="Csatorna frissítése", font=('italic', 10), bg="white", command=csatornat_frissit)
    csatornat_torol_button = tk.Button(root, text="Csatorna törlése", font=('italic', 10), bg="white", command=csatornat_torol)
    csatornat_hozzaad_button = tk.Button(root, text="Csatorna hozzáadása", font=('italic', 10), bg="white", command=csatornat_hozzaad)
    musort_hozzaad_button = tk.Button(root, text="Műsor hozzáadása", font=('italic', 10), bg="white", command=musort_hozzaad)
    musort_torol_button = tk.Button(root, text="Műsor törlése", font=('italic', 10), bg="white", command=musort_torol)
    musort_frissit_button = tk.Button(root, text="Műsor frissítése", font=('italic', 10), bg="white", command=musort_frissit)
    szereplo_torlese_button = tk.Button(root, text="Szereplő törlése", font=('italic', 10), bg="white", command=szereplot_torol)
    szereplo_hozzaadasa_button = tk.Button(root, text="Szereplő hozzáadása", font=('italic', 10), bg="white", command=szereplot_hozzaad)
    szereplo_frissitese_button = tk.Button(root, text="Szereplő frissítése", font=('italic', 10), bg="white", command=szereplot_frissit)
    legfiatalabb_szereplok_nemzetisegenkent_button = tk.Button(root, text="Legfiatalabb szereplők", font=('italic', 10), bg="white", command=legfiatalabb_szereplo_nemzetisegenkent)
    epizod_frissitese_button = tk.Button(root, text="Epizódok frissítése", font=('italic', 10), bg="white", command=epizodot_frissit)
    szereplo_neve_label = tk.Label(root, text="Szereplő neve:")
    szereplo_neve_entry = tk.Entry(root)
    szuletesi_datum_label = tk.Label(root, text="Születési dátum:")
    szuletesi_datum_entry = tk.Entry()
    nemzetiseg_label = tk.Label(root, text="Nemzetiség:")
    nemzetiseg_entry = tk.Entry(root)
    foglalkozas_label = tk.Label(root, text="Foglalkozás:")
    foglalkozas_entry = tk.Entry(root)
    musor_label = tk.Label(root, text="Műsor, amiben szerepel:")
    musor_entry = tk.Entry(root)
    szereplo_kereses_button = tk.Button(root, text="Szereplő keresése", font=('italic', 10), bg="white", command=musorok_listazasa)

    root.mainloop()