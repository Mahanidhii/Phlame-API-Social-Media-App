import requests
import json

API_URL="http://localhost/Phlame"
session = requests.Session()

# Function & API call for user registration
def register_user():
    print("\n ~ Register as a New User ~ \n")
    username=input("Enter a USERNAME: ")
    password=input("Enter PASSWORD: ")

    if ' ' in username:
        print("\nError :  Username cannot contain spaces. Please try again\n")
        return
    
    if not username or not password:
        print("\n Username and password cannot be empty\n")
        return
    
    try:
        endpoint=f"{API_URL}/users/register"
        payload={"username": username, "password":password}
        response=session.post(endpoint, json=payload)

        print("\n Server Response: ")
        print(response.json(),"\n")
    except requests.exceptions.RequestException as e:
        print(f"\n Error : Could not connect to the server : {e} \n")


# Function & API call for user login
def login_user():
    while True:
        print("\n ~ User Login ~ \n")
        username=input("Enter your USERNAME: ")
        password=input("Enter your PASSWORD: ")

        try:
            endpoint = f"{API_URL}/login"
            payload = {"username": username, "password": password}
            response = session.post(endpoint, json=payload)
            response_data = response.json()

            if response_data.get('segments', {}).get('data', {}).get('status') == 'success':
                print("\nServer Response:")
                print(response_data,"\n")
                print("\nLogin successful!\n")
                return username 
            else:
                print("\nServer Response:")
                print(response_data,"n")
                print("\nError : Login failed. Please try again or press Ctrl+C to go back.\n")

        except requests.exceptions.RequestException as e:
            print(f"\nError : Could not connect to the server: {e}\n")
            return None
        except json.JSONDecodeError:
            print("\nError :  Failed to decode server response \n")
            return None


# Function & API call for showing the feed
def view_posts():
    print("\n ~ TODAY'S FEED ~ \n")
    try:
        endpoint = f"{API_URL}/posts"
        response = session.get(endpoint)
        response.raise_for_status()

        data=response.json()

        if data.get('segments') and data['segments'].get('posts'):
            posts=data['segments']['posts']
            if not posts:
                print("\n NO POSTS FOR NOW!\n ")

            for post in posts:
                print("-" * 20)
                print(f"Post ID: {post['id']}")
                print(f"Username: {post['username']}")
                print(f"Post: {post['content']}")
                print(f"Like Count: {post['like_count']}")
                print(f"Date: {post['created_at']}")
                print("-" * 20)

                action=input("\nPress 'L' to like the post or Enter to go to the next post \n")
                if action.lower()=='l':
                    like_post(post['id'])
            print("\n --------END OF FEED--------")
            input("\n Press enter to return to the menu\n")


        else:
            print("\nCould not find any more posts in the database\n")
            print("Server Response: ", data,"\n")

    except requests.exceptions.RequestException as e:
        print(f"\n Could not fetch posts: {e}\n")
    except json.JSONDecodeError:
        print("\n Error : Failed to decode server response.\n")


# Function & API call for making a post
def create_post():
    print("\n  ~ Create a new POST ~ \n")
    content=input("What's on your mind today?? \n POST IT : ")

    if not content:
        print("\n The post cannot be empty\n")
        return
    try:
        endpoint=f"{API_URL}/posts"
        payload={"content": content}
        response=session.post(endpoint, json=payload)

        print("Server Response")
        print(response.json())

    except requests.exceptions.RequestException as e:
        print(f"\n Error : Could not create post {e} \n")


# Function & API call for liking a post
def like_post(post_id):
    try:
        endpoint=f"{API_URL}/posts/{post_id}/like"
        response=session.post(endpoint)

        print("\n Serve Response: ")
        print(response.json(),"\n")

    except requests.exceptions.RequestException as e:
        print(f"\n Error : Could not like the post!!\n")



# Main Method to run the entire python CLI
def main():
    logged_in_user = None # State variable(for log in state)
    while True:
        print("\n|~~~~ Phlame Social Media App ~~~~|\n")

        if logged_in_user:
            print(f"Logged in as: {logged_in_user}")
        print("1. Register a new user")
        print("2. Login")
        print("3. View all posts")
        #Displays the (Login required) according to the state variable
        if logged_in_user:
            print("4. Make a post")
        else:
            print("4. Make a post (Login required)")
        print("5. Exit the app")



        choice=input("Enter your choice : ").strip()        



        if choice=='1':
            register_user()
        elif choice == '2':
            user=login_user()
            if user:
                logged_in_user = user
        elif choice=='3':
            view_posts()
        elif choice=='4':
            create_post()
        elif choice == '5':
            print("\nSee ya, Goodbye!\n")
            break
        else:
            print("Invalid choice. Please enter an option between 1 & 5")

if __name__=="__main__":
    main()