acc_history = [0,0,0,0,0,0,0,0,0]
def acc_smooth(accelleration):

    x1 = acc_history[0]
    x2 = acc_history[1]
    x3 = acc_history[2]
    x4 = acc_history[3]
    x5 = acc_history[4]
    x6 = acc_history[5]
    x7 = acc_history[6]
    x8 = acc_history[7]
    x9 = acc_history[8]
    xn = accelleration

    acc_history[8] = xn
    acc_history[7] = x9
    acc_history[6] = x8
    acc_history[5] = x7
    acc_history[4] = x6
    acc_history[3] = x5
    acc_history[2] = x4
    acc_history[1] = x3
    acc_history[0] = x2

    return x1*0.05 + x2*0.05 + x3*0.06 + x4*0.07 + x5*0.08 + x6*0.1 + x7*0.12 + x8*0.15 + x9*0.15 + xn*0.17